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
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerSettingsManager;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class DefaultSettings extends Model
{
    const SETTING_PINNED_FIRST = 'defaults.pinnedFirst';

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @var integer
     */
    public $pinned_first;

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
            [['pinned_first'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pinned_first' => Yii::t('BookmarkModule.forms', 'Show pinned content first.'),
        ];
    }

    public function save()
    {
        $settings = $this->getSettings();
        $settings->set(self::SETTING_PINNED_FIRST, $this->pinned_first);
        return true;
    }

    public function reset()
    {
        $settings = $this->getSettings();
        $settings->set(self::SETTING_PINNED_FIRST, null);
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
}
