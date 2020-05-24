<?php

use yii\db\Migration;

/**
 * Class m200524_221518_unique_tag_name
 */
class m200524_221518_unique_tag_name extends Migration
{
    private const TABLE = 'tag';
    private const COLUMN = 'name';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE, self::COLUMN, 'varchar(45) unique');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::TABLE, self::COLUMN, 'varchar(45)');
    }
}
