<?php

use yii\db\Migration;

/**
 * Class m200417_101338_remove_social_activities
 */
class m200417_101338_remove_social_activities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('DELETE activity, content FROM activity INNER JOIN content ON activity.id = content.object_id AND content.object_model=:class WHERE activity.object_model=:bookmarkClass;', [':class' => \humhub\modules\activity\models\Activity::class, ':bookmarkClass' => \humhub\modules\bookmark\models\Bookmark::class])
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200417_101338_remove_social_activities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200417_101338_remove_social_activities cannot be reverted.\n";

        return false;
    }
    */
}
