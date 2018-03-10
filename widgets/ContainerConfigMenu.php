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
use humhub\widgets\SettingsTabs;

class ContainerConfigMenu extends SettingsTabs
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $contentContainer = Yii::$app->controller->contentContainer;

        $this->items = [
            [
                'label' => Yii::t('BookmarkModule.widgets_GlobalConfigMenu', 'Defaults'),
                'url' => $contentContainer->createUrl('/bookmark/container-config/index'),
                'active' => $this->isCurrentRoute('bookmark', 'container-config', 'index')
            ],
        ];

        parent::init();
    }

}