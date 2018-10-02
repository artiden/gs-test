<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phones`.
 * Has foreign keys to the tables:
 *
 * - `users`
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
            'user_id' => $this->integer()->notnull(),
            'phone' => $this->string()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-phones-user_id',
            'phones',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-phones-user_id',
            'phones',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-phones-user_id',
            'phones'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-phones-user_id',
            'phones'
        );

        $this->dropTable('phones');
    }
}
