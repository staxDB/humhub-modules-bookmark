<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\notifications;

use Yii;
use humhub\modules\notification\components\NotificationCategory;
use humhub\modules\notification\targets\BaseTarget;
use humhub\modules\notification\targets\MailTarget;

/**
 * BookmarkNotificationCategory
 *
 * @author buddha
 */
class BookmarkNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = 'bookmark';

    /**
     * @inheritdoc
     */
    public function getDefaultSetting(BaseTarget $target)
    {
        if ($target instanceof MailTarget) {
            return false;
        }

        return parent::getDefaultSetting($target);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('BookmarkModule.notifications_BookmarkNotificationCategory', 'Bookmark');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('BookmarkModule.notifications_BookmarkNotificationCategory', 'Receive Notifications when someone bookmarked your content.');
    }

}
