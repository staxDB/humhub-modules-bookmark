<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\widgets;

use Yii;
use humhub\modules\stream\widgets\StreamViewer as BaseStreamViewer;
use humhub\modules\post\permissions\CreatePost;

/**
 * StreamViewer shows a users bookmark stream
 * 
 * @author davidborn
 */
class ProfileBookmarkStreamViewer extends BaseStreamViewer
{

    /**
     * @var string the path to Stream Action to use
     */
    public $streamAction = '/bookmark/profile/stream';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $createPostPermission = new CreatePost();

        if (empty($this->messageStreamEmptyCss)) {
            if ($this->contentContainer->permissionManager->can($createPostPermission)) {
                $this->messageStreamEmptyCss = 'placeholder-empty-stream';
            }
        }

        if (empty($this->messageStreamEmpty)) {
            if ($this->contentContainer->permissionManager->can($createPostPermission)) {
                if (Yii::$app->user->id === $this->contentContainer->id) {
                    $this->messageStreamEmpty = Yii::t('BookmarkModule.widgets_views_stream', '<b>You have not set a bookmark yet!</b><br>Search for content that interests you and bookmark it!');
                } else {
                    $this->messageStreamEmpty = Yii::t('BookmarkModule.widgets_views_stream', '<b>This bookmark stream is still empty</b><br>Be the first and post something...');
                }
            } else {
                $this->messageStreamEmpty = Yii::t('BookmarkModule.widgets_views_stream', '<b>This bookmark stream is still empty!</b>');
            }
        }

        parent::init();
    }

}
