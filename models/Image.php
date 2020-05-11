<?php

namespace app\models;

use Yii;

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
}
