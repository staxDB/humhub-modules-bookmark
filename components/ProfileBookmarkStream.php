<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\components;

use humhub\modules\stream\actions\ContentContainerStream;
use Yii;
use yii\db\Query;
use humhub\modules\stream\actions\Stream;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\space\models\Membership;
use humhub\modules\content\models\Content;
use humhub\modules\bookmark\Module;

/**
 * BookmarkStreamAction
 * 
 * Note: This stream action is also used for activity e-mail content.
 *
 * @author davidborn
 */
class ProfileBookmarkStream extends Stream
{

    /**
     * @var \humhub\modules\content\components\ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $friendshipEnabled = Yii::$app->getModule('friendship')->getIsEnabled();

        $this->activeQuery->leftJoin('bookmark', 'content.object_id=bookmark.object_id and content.object_model=bookmark.object_model');
        $this->activeQuery->orWhere(['content.stream_channel' => null]);    // also show hidden contents
        $this->activeQuery->andWhere(['bookmark.created_by' => $this->contentContainer->id]);

        // Limit to public posts when no member
        if (!$this->contentContainer->canAccessPrivateContent($this->user)) {
            if (!Yii::$app->user->isGuest) {
                $this->activeQuery->andWhere("content.visibility=" . Content::VISIBILITY_PUBLIC . " OR content.created_by = :userId", [':userId' => $this->user->id]);
            } else {
                $this->activeQuery->andWhere("content.visibility=" . Content::VISIBILITY_PUBLIC);
            }
        }

        // Add all pinned contents to initial request
        if ($this->isInitialRequest()) {
            // Get number of pinned contents
            $pinnedQuery = clone $this->activeQuery;
            $pinnedQuery->andWhere(['content.pinned' => 1]);
            $pinnedCount = $pinnedQuery->count();

            // Increase query result limit to ensure there are also not pinned entries
            $this->activeQuery->limit += $pinnedCount;

            // Modify order - pinned content first
            $oldOrder = $this->activeQuery->orderBy;
            $this->activeQuery->orderBy("");
            $this->activeQuery->addOrderBy('content.pinned DESC');
            $this->activeQuery->addOrderBy($oldOrder);
        } else {
            // No pinned content in further queries
            $this->activeQuery->andWhere("content.pinned = 0");
        }

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
