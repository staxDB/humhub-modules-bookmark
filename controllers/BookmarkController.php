<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\controllers;

use Yii;
use humhub\modules\bookmark\models\Bookmark;
use humhub\modules\user\widgets\UserListBox;
use humhub\modules\content\components\ContentAddonController;

/**
 * Bookmark Controller
 *
 * Handles requests by the bookmark widgets. (e.g. bookmark, unbookmark, show bookmarks)
 *
 */
class BookmarkController extends ContentAddonController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'guestAllowedActions' => ['show-bookmarks']
            ]
        ];
    }

    /**
     * Creates a new bookmark
     */
    public function actionBookmark()
    {
        $this->forcePostRequest();

        $bookmark = Bookmark::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
        if ($bookmark === null) {

            // Create Bookmark Object
            $bookmark = new Bookmark([
                'object_model' => $this->contentModel,
                'object_id' => $this->contentId
            ]);
            $bookmark->save();
        }

        return $this->actionShowBookmarks();
    }

    /**
     * Unbookmarks an item
     */
    public function actionUnbookmark()
    {
        $this->forcePostRequest();

        if (!Yii::$app->user->isGuest) {
            $bookmark = Bookmark::findOne(['object_model' => $this->contentModel, 'object_id' => $this->contentId, 'created_by' => Yii::$app->user->id]);
            if ($bookmark !== null) {
                $bookmark->delete();
            }
        }

        return $this->actionShowBookmarks();
    }

    /**
     * Returns an JSON with current bookmark informations about a target
     */
    public function actionShowBookmarks()
    {
        Yii::$app->response->format = 'json';

        // Some Meta Infos
        $currentUserBookmarked = false;

        $bookmarks = Bookmark::GetBookmarks($this->contentModel, $this->contentId);

        foreach ($bookmarks as $bookmark) {
            if ($bookmark->user->id == Yii::$app->user->id) {
                $currentUserBookmarked = true;
            }
        }

        return [
            'currentUserBookmarked' => $currentUserBookmarked,
            'bookmarkCounter' => count($bookmarks)
        ];
    }

    /**
     * Returns a user list which contains all users who bookmarked it
     */
    public function actionUserList()
    {

        $query = \humhub\modules\user\models\User::find();
        $query->leftJoin('bookmark', 'bookmark.created_by=user.id');
        $query->where([
            'bookmark.object_id' => $this->contentId,
            'bookmark.object_model' => $this->contentModel,
        ]);
        $query->orderBy('bookmark.created_at DESC');

        $title = Yii::t('BookmarkModule.controllers_BookmarkController', '<strong>Users</strong> who bookmarked this');

        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

}
