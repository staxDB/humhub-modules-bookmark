<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark;

use humhub\modules\bookmark\models\forms\ConfigForm;
use humhub\modules\bookmark\permissions\ViewBookmarkStream;
use Yii;
use yii\helpers\Url;
use humhub\modules\bookmark\models\Bookmark;

/**
 * Events provides callbacks to handle events.
 * 
 * @author luke
 */
class Events extends \yii\base\Object
{

    /**
     * On build of the TopMenu, check if module is enabled
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onTopMenuInit($event)
    {

        // Is Module enabled on this workspace?
        $event->sender->addItem(array(
            'label' => Yii::t('BookmarkModule.base', 'Bookmarks'),
            'id' => 'bookmark',
            'icon' => '<i class="fa fa-bookmark"></i>',
            'url' => Url::toRoute('/bookmark/index'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'bookmark'),
        ));
    }

    public static function onProfileMenuInit($event)
    {
        $user = $event->sender->user;
        if ($user->isModuleEnabled('bookmark')) {
                if ($user->permissionManager->can(new ViewBookmarkStream())) {
                $event->sender->addItem([
                    'label' => Yii::t('BookmarkModule.base', 'Bookmarks'),
                    'url' => $user->createUrl('/bookmark/profile/show'),
                    'icon' => '<i class="fa fa-bookmark"></i>',
                    'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'bookmark'),
                ]);
            }
        }
    }

    /**
     * On User delete, also delete all bookmarks
     */
    public static function onUserDelete($event)
    {
        foreach (Bookmark::findAll(array('created_by' => $event->sender->id)) as $bookmark) {
            $bookmark->delete();
        }

        return true;
    }

    /**
     * On content delete, also delete all bookmarks
     */
    public static function onActiveRecordDelete($event)
    {
        $record = $event->sender;
        if ($record->hasAttribute('id')) {
            foreach (Bookmark::findAll(array('object_id' => $record->id, 'object_model' => $record->className())) as $bookmark) {
                $bookmark->delete();
            }
        }
    }

    /**
     * Callback to validate module database records.
     */
    public static function onIntegrityCheck($event)
    {
        $integrityController = $event->sender;
        $integrityController->showTestHeadline("Bookmark (" . Bookmark::find()->count() . " entries)");

        foreach (Bookmark::find()->all() as $bookmark) {
            if ($bookmark->source === null) {
                if ($integrityController->showFix("Deleting bookmark id " . $bookmark->id . " without existing target!")) {
                    $bookmark->delete();
                }
            }
            // User doesn't exists
            if ($bookmark->user === null) {
                if ($integrityController->showFix("Deleting bookmark id " . $bookmark->id . " without existing user!")) {
                    $bookmark->delete();
                }
            }
        }
    }

    /**
     * On initalizing the wall entry controls also add the bookmark link widget
     *
     * @param type $event
     */
    public static function onWallEntryLinksInit($event)
    {
        $event->sender->addWidget(widgets\BookmarkLink::className(), ['object' => $event->sender->object], ['sortOrder' => ConfigForm::instantiate()->sortOrder]);
    }

}
