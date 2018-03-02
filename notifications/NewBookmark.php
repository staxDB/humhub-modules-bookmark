<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\notifications;

use Yii;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;

/**
 * Notifies a user about bookmark of his objects (posts, comments, tasks & co)
 *
 * @since 0.5
 */
class NewBookmark extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'bookmark';

    /**
     * @inheritdoc
     */
    public $viewName = 'newBookmark';

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new BookmarkNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getGroupKey()
    {
        $model = $this->getBookmarkedRecord();
        return $model->className() . '-' . $model->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        $contentInfo = $this->getContentInfo($this->getBookmarkedRecord());

        if ($this->groupCount > 1) {
            return Yii::t('BookmarkModule.notification', '{displayNames} bookmarked your {contentTitle}.', [
                        'displayNames' => strip_tags($this->getGroupUserDisplayNames()),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('BookmarkModule.notification', '{displayName} bookmarked your {contentTitle}.', [
                    'displayName' => Html::encode($this->originator->displayName),
                    'contentTitle' => $contentInfo
        ]);
    }

    public function getBookmarkedReccord()
    {
        return $this->source->getPolyMorphicRelation();
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        $contentInfo = $this->getContentInfo($this->getBookmarkedRecord());

        if ($this->groupCount > 1) {
            return Yii::t('BookmarkModule.notification', '{displayNames} bookmarked {contentTitle}.', [
                        'displayNames' => $this->getGroupUserDisplayNames(),
                        'contentTitle' => $contentInfo
            ]);
        }

        return Yii::t('BookmarkModule.notification', '{displayName} bookmarked {contentTitle}.', [
                    'displayName' => Html::tag('strong', Html::encode($this->originator->displayName)),
                    'contentTitle' => $contentInfo
        ]);
    }

    /**
     * The bookmarked record
     * 
     * @return \humhub\components\ActiveRecord
     */
    protected function getBookmarkedRecord()
    {
        return $this->source->getSource();
    }

}
