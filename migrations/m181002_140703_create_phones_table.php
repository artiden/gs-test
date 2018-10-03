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
            'person_id' => $this->integer(),
            'value' => $this->string()->notNull(),
        ]);

        // creates index for column `person_id`
        $this->createIndex(
            'idx-phones-person_id',
            'phones',
            'person_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-phones-person_id',
            'phones',
            'person_id',
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
            'fk-phones-person_id',
            'phones'
        );

        // drops index for column `person_id`
        $this->dropIndex(
            'idx-phones-person_id',
            'phones'
        );

        $this->dropTable('phones');
    }
}
