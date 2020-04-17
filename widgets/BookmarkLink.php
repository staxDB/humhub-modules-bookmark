<?php

namespace humhub\modules\bookmark\widgets;

use humhub\modules\bookmark\models\forms\ConfigForm;
use humhub\modules\bookmark\models\forms\DefaultSettings;
use Yii;
use humhub\modules\bookmark\models\Bookmark;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This widget is used to show a bookmark link inside the wall entry controls.
 *
 */
class BookmarkLink extends \yii\base\Widget
{

    /**
     * The Object to be bookmarked
     *
     * @var type
     */
    public $object;

    /**
     * Executes the widget.
     */
    public function run()
    {
        $currentUserBookmarked = false;

        $bookmarks = Bookmark::GetBookmarks($this->object->className(), $this->object->id);
        foreach ($bookmarks as $bookmark) {
            if ($bookmark->user->id == Yii::$app->user->id) {
                $currentUserBookmarked = true;
            }
        }

        $settings = ConfigForm::instantiate();
        $defaultSettings = DefaultSettings::instantiate();

        return $this->render('bookmarkLink', array(
                    'bookmarks' => $bookmarks,
                    'settings' => $settings,
                    'defaultSettings' => $defaultSettings,
                    'currentUserBookmarked' => $currentUserBookmarked,
                    'id' => $this->object->getUniqueId(),
                    'bookmarkUrl' => Url::to(['/bookmark/bookmark/bookmark', 'contentModel' => $this->object->className(), 'contentId' => $this->object->id]),
                    'unbookmarkUrl' => Url::to(['/bookmark/bookmark/unbookmark', 'contentModel' => $this->object->className(), 'contentId' => $this->object->id]),
                    'userListUrl' => Url::to(['/bookmark/bookmark/user-list', 'contentModel' => $this->object->className(), 'contentId' => $this->object->getPrimaryKey()]),
                    'title' => $this->generateBookmarkTitleText($currentUserBookmarked, $bookmarks)
        ));
    }

    private function generateBookmarkTitleText($currentUserBookmarked, $bookmarks)
    {
        $userlist = ""; // variable for users output
        $maxUser = 5; // limit for rendered users inside the tooltip
        // if the current user also bookmarked
        if ($currentUserBookmarked == true) {
            // if only one user bookmarks
            if (count($bookmarks) == 1) {
                // output, if the current user is the only one
                $userlist = Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'You bookmarked this.');
            } else {
                // output, if more users bookmark this
                $userlist .= Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'You'). "\n";
            }
        }

        for ($i = 0, $bookmarksCount = count($bookmarks); $i < $bookmarksCount; $i++) {

            // if only one user bookmarks
            if ($bookmarksCount == 1) {
                // check, if you bookmarked
                if ($bookmarks[$i]->user->guid != Yii::$app->user->guid) {
                    // output, if an other user bookmarked
                    $userlist .= Html::encode($bookmarks[$i]->user->displayName) . Yii::t('BookmarkModule.widgets_views_bookmarkLink', ' bookmarked this.');
                }
            } else {

                // check, if you bookmarked
                if ($bookmarks[$i]->user->guid != Yii::$app->user->guid) {
                    // output, if an other user bookmarked
                    $userlist .= Html::encode($bookmarks[$i]->user->displayName). "\n";
                }

                // check if exists more user as limited
                if ($i == $maxUser) {
                    // output with the number of not rendered users
                    $userlist .= Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'and {count} more bookmarked this.', array('{count}' => (int)(count($bookmarks) - $maxUser)));

                    // stop the loop
                    break;
                }
            }
        }

        return $userlist;
    }

}

?>