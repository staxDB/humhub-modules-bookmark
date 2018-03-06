<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\components;

use Yii;
use humhub\modules\stream\actions\Stream;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\space\models\Membership;

/**
 * BookmarkStreamAction
 * 
 * Note: This stream action is also used for activity e-mail content.
 *
 * @author davidborn
 */
class BookmarkStream extends Stream
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $friendshipEnabled = Yii::$app->getModule('friendship')->getIsEnabled();

        $this->activeQuery->leftJoin('bookmark', 'content.object_id=bookmark.object_id and content.object_model=bookmark.object_model');
        $this->activeQuery->orWhere(['content.stream_channel' => null]);    // also show hidden contents
        $this->activeQuery->andWhere(['bookmark.created_by' => Yii::$app->user->id]);

        /**
         * Begin visibility checks regarding the content container
         */
        $this->activeQuery->leftJoin(
            'space_membership', 'contentcontainer.pk=space_membership.space_id AND space_membership.user_id=:userId AND space_membership.status=:status', ['userId' => $this->user->id, ':status' => Membership::STATUS_MEMBER]
        );
        if ($friendshipEnabled) {
            $this->activeQuery->leftJoin(
                'user_friendship', 'contentcontainer.pk=user_friendship.user_id AND user_friendship.friend_user_id=:userId', ['userId' => $this->user->id]
            );
        }

        $condition = ' (contentcontainer.class=:userModel AND content.visibility=0 AND content.created_by = :userId) OR ';
        if ($friendshipEnabled) {
            // In case of friendship we can also display private content
            $condition .= ' (contentcontainer.class=:userModel AND content.visibility=0 AND user_friendship.id IS NOT NULL) OR ';
        }
        // In case of an space entry, we need to join the space membership to verify the user can see private space content
        $condition .= ' (contentcontainer.class=:spaceModel AND content.visibility = 0 AND space_membership.status = ' . Membership::STATUS_MEMBER . ') OR ';
        $condition .= ' (content.visibility = 1 OR content.visibility IS NULL) ';
        $this->activeQuery->andWhere($condition, [':userId' => $this->user->id, ':spaceModel' => Space::className(), ':userModel' => User::className()]);
    }

}
