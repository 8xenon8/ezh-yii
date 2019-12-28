<?php

use yii\db\Migration;

/**
 * Class m191215_003712_add_created_at_and_updated_at_to_image
 */
class m191215_003712_add_created_at_and_updated_at_to_image extends Migration
{
    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Image::tableName(), self::CREATED_AT, 'timestamp default current_timestamp');
        $this->addColumn(\app\models\Image::tableName(), self::UPDATED_AT, 'timestamp default current_timestamp');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\app\models\Image::tableName(), self::CREATED_AT);
        $this->dropColumn(\app\models\Image::tableName(), self::UPDATED_AT);
    }
}
