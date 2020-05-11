<?php

use yii\db\Migration;

/**
 * Class m200511_222509_make_gallery_id_not_obligatory
 */
class m200511_222509_make_gallery_id_not_obligatory extends Migration
{
    private const tableName = 'image';
    private const columnName = 'gallery_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::tableName, self::columnName, 'INT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::tableName, self::columnName, 'INT not null');
    }
}
