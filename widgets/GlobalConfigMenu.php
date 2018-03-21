<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

/**
 * @author davidborn
 */

namespace humhub\modules\bookmark\widgets;


use Yii;
use yii\helpers\Url;
use humhub\widgets\SettingsTabs;

class GlobalConfigMenu extends SettingsTabs
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->items = [
            [
                'label' => Yii::t('BookmarkModule.widgets_GlobalConfigMenu', 'Defaults'),
                'url' => Url::toRoute(['/bookmark/config/index']),
                'active' => $this->isCurrentRoute('bookmark', 'config', 'index'),
                'sortOrder' => 10
            ],
            [
                'label' => Yii::t('BookmarkModule.widgets_GlobalConfigMenu', 'Global Settings'),
                'url' => Url::toRoute(['/bookmark/config/config']),
                'active' => $this->isCurrentRoute('bookmark', 'config', 'config'),
                'sortOrder' => 20
            ],
        ];

        parent::init();
    }

}