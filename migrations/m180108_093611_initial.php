<?php

use yii\db\Migration;

class m180108_093611_initial extends Migration
{
    public function up()
    {
        $this->createTable('bookmark', array(
            'id' => 'pk',
            'target_user_id' => 'int(11) DEFAULT NULL',
            'object_model' => 'varchar(100) NOT NULL',
            'object_id' => 'int(11) NOT NULL',
            'created_at' => 'datetime DEFAULT NULL',
            'created_by' => 'int(11) DEFAULT NULL',
            'updated_at' => 'datetime DEFAULT NULL',
            'updated_by' => 'int(11) DEFAULT NULL',
        ), '');

        $this->createIndex('index_object', 'bookmark', 'object_model, object_id', false);
        $this->addForeignKey('fk_bookmark-created_by', 'bookmark', 'created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bookmark-target_user_id', 'bookmark', 'target_user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_bookmark-created_by', 'bookmark');
        $this->dropForeignKey('fk_bookmark-target_user_id', 'bookmark');
//        echo "m180108_093611_initial cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
