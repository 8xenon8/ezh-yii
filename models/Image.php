<?php

namespace app\models;

use himiklab\sortablegrid\SortableGridBehavior;
use yii\base\Event;
use Yii;
use yii\db\BaseActiveRecord;
use yii\db\Transaction;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $gallery_id
 * @property string|null $orig
 * @property string|null $preview
 * @property string|null $thumb
 * @property int|null $orig_width
 * @property int|null $orig_height
 * @property int|null $preview_width
 * @property int|null $preview_height
 * @property int|null $thumb_width
 * @property int|null $thumb_height
 * @property bool|null $publish
 * @property int|null $order
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Gallery $gallery
 * @property ImageHasTag[] $imageHasTags
 * @property Tag[] $tags
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['gallery_id', 'orig_width', 'orig_height', 'preview_width', 'preview_height', 'thumb_width', 'thumb_height', 'order'], 'integer'],
            [['publish'], 'boolean'],
            [['created_at', 'updated_at', 'gallery_id'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['orig', 'preview', 'thumb'], 'string', 'max' => 45],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'gallery_id' => 'Gallery ID',
            'orig' => 'Orig',
            'preview' => 'Preview',
            'thumb' => 'Thumb',
            'orig_width' => 'Orig Width',
            'orig_height' => 'Orig Height',
            'preview_width' => 'Preview Width',
            'preview_height' => 'Preview Height',
            'thumb_width' => 'Thumb Width',
            'thumb_height' => 'Thumb Height',
            'publish' => 'Publish',
            'order' => 'Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['name', 'description', 'publish', 'order'],
            'create' => ['orig', 'orig_width', 'orig_height', 'preview', 'preview_width', 'preview_height', 'thumb', 'thumb_width', 'thumb_height']
        ];
    }

    public function init()
    {
        $this->on(BaseActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'beforeUpdate']);
    }

    /**
     * Gets query for [[Gallery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }

    /**
     * Gets query for [[ImageHasTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageHasTags()
    {
        return $this->hasMany(ImageHasTag::className(), ['image_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('image_has_tag', ['image_id' => 'id']);
    }

    /**
     * Cleans up the files before AR is deleted
     * @return bool
     */
    public function beforeDelete()
    {
        $service = new \app\services\ImageProcessingService();
        $service->deleteImageFiles($this);
        return true;
    }

    /**
     * @param string $tagName
     * @return bool
     */
    public function hasTag(string $tagName) : bool
    {
        foreach ($this->tags as $tag)
        {
            if ($tag->name == $tagName) { return true; }
        }
        return false;
    }

    /**
     * @param Event $event
     */
    public function beforeUpdate(Event $event) : void
    {
        if (get_class($event->sender) === self::class)
        {
            /** @var self $model */
            $model = $event->sender;

            if ($model->getAttribute('order') !== $model->getOldAttribute('order'))
            {
                $model->sortItems($model->getOldAttribute('order'), $model->getAttribute('order'));
            }
        }
    }

    /**
     * Sorts other items accordingly to current order value change
     * @param int $oldOrder
     * @param int $newOrder
     */
    protected function sortItems(int $oldOrder, int $newOrder) : void
    {
        /** @var Transaction $transaction */
        $transaction = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);

        try {
            \Yii::$app->db->createCommand(
                "
                    UPDATE `image`
                    SET `order`=`order` + :increment
                    WHERE (`order` between :minVal and :maxVal)
                    and id != :idImage
                ",
                [
                    ':minVal' => min($oldOrder, $newOrder),
                    ':maxVal' => max($oldOrder, $newOrder),
                    ':increment' => ($oldOrder > $newOrder) ? 1 : -1,
                    ':idImage' => $this->id
                ]
            )->execute();

            $transaction->commit();
        } catch (\Exception $exception)
        {
            $transaction->rollBack();
        }
    }
}
