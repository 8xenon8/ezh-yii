<?php

use yii\db\Migration;

/**
 * Class m200522_115453_obligatory_orig_preview_thumb_fields
 */
class m200522_115453_obligatory_orig_preview_thumb_fields extends Migration
{
    private const TABLE = "image";
    private const COLUMN_ORIG = "orig";
    private const COLUMN_PREVIEW = "preview";
    private const COLUMN_THUMB = "thumb";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE, self::COLUMN_ORIG, "varchar(255) NOT NULL");
        $this->alterColumn(self::TABLE, self::COLUMN_PREVIEW, "varchar(255) NOT NULL");
        $this->alterColumn(self::TABLE, self::COLUMN_THUMB, "varchar(255) NOT NULL");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::TABLE, self::COLUMN_ORIG, "varchar(255)");
        $this->alterColumn(self::TABLE, self::COLUMN_PREVIEW, "varchar(255)");
        $this->alterColumn(self::TABLE, self::COLUMN_THUMB, "varchar(255)");
    }
}
