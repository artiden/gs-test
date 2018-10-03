<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phones`.
 * Has foreign keys to the tables:
 *
 * - `persons`
 */
class m181002_140703_create_phones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('phones', [
            'id' => $this->primaryKey(),
            'personId' => $this->integer(),
            'value' => $this->string()->notNull(),
        ]);

        // creates index for column `personId`
        $this->createIndex(
            'idx-phones-personId',
            'phones',
            'personId'
        );

        // add foreign key for table `persons`
        $this->addForeignKey(
            'fk-phones-personId',
            'phones',
            'personId',
            'persons',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `persons`
        $this->dropForeignKey(
            'fk-phones-personId',
            'phones'
        );

        // drops index for column `personId`
        $this->dropIndex(
            'idx-phones-personId',
            'phones'
        );

        $this->dropTable('phones');
    }
}
