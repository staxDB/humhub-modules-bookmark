<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

/**
 */

namespace humhub\modules\bookmark\models\forms;

use humhub\components\SettingsManager;
use humhub\modules\bookmark\notifications\NewBookmark;
use humhub\modules\content\components\ContentContainerActiveRecord;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class DefaultSettings extends Model
{
    const SETTING_PINNED_FIRST = 'defaults.pinnedFirst';
    const SETTING_PRIVATE_BOOKMARKING = 'defaults.privateBookmarking';

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @var integer
     */
    public $pinned_first;

    /**
     * @var integer
     */
    public $private_bookmarking;

    /**
     * @var SettingsManager
     */
    private $settings;

    public function init()
    {
        $this->initSettings();
    }

    private function initSettings()
    {
        $this->pinned_first = (int) $this->getSetting(self::SETTING_PINNED_FIRST, 0);
        $this->private_bookmarking = (int) $this->getSetting(self::SETTING_PRIVATE_BOOKMARKING, 0);
    }

    /**
     * Returns either the inherited value of $key in case a contentContainer is set or the global value.
     * @return mixed
     */
    public function getSetting($key, $default = null)
    {
        return ($this->contentContainer) ? $this->getSettings()->getInherit($key, $default) : $this->getSettings()->get($key, $default);
    }

    private function getSettings()
    {
        if(!$this->settings) {
            $module = Yii::$app->getModule('bookmark');
            $this->settings = ($this->contentContainer) ? $module->settings->contentContainer($this->contentContainer) : $module->settings;
        }

        return $this->settings;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pinned_first', 'private_bookmarking'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pinned_first' => Yii::t('BookmarkModule.forms', 'Show pinned content first.'),
            'private_bookmarking' => Yii::t('BookmarkModule.forms', 'Keep bookmarks private and do not send notifications or create social activities.'),
        ];
    }

    public function save()
    {
        $settings = $this->getSettings();
        $settings->set(self::SETTING_PINNED_FIRST, $this->pinned_first);
        $settings->set(self::SETTING_PRIVATE_BOOKMARKING, $this->private_bookmarking);
        if ($this->private_bookmarking) {
            // remove all existing notifications
            NewBookmark::instance()->delete();
        }
        return true;
    }

    public function reset()
    {
        $settings = $this->getSettings();
        $settings->set(self::SETTING_PINNED_FIRST, null);
        $settings->set(self::SETTING_PRIVATE_BOOKMARKING, null);
        $this->initSettings();
    }

    public function isGlobal()
    {
        return $this->contentContainer === null;
    }

    public function getResetButtonUrl()
    {
        return ($this->isGlobal()) ? Url::to(['/bookmark/config/reset-config']) : $this->contentContainer->createUrl('/bookmark/container-config/reset-config');
    }

    public function getSubmitUrl()
    {
        return ($this->isGlobal()) ? Url::to(['/bookmark/config']) : $this->contentContainer->createUrl('/bookmark/container-config');
    }

    /**
     * Static initializer
     * @return \self
     */
    public static function instantiate()
    {
        return new self;
    }
}
