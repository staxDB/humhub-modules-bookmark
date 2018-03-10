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

namespace humhub\modules\bookmark\controllers;


use Yii;
use humhub\modules\admin\permissions\ManageSpaces;
use humhub\modules\bookmark\permissions\ManageBookmark;
use humhub\modules\bookmark\models\forms\DefaultSettings;
use humhub\modules\content\components\ContentContainerController;

class ContainerConfigController extends ContentContainerController
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
          ['permission' => [ManageSpaces::class, ManageBookmark::class]]
        ];
    }

    public function actionIndex()
    {
        $model = new DefaultSettings(['contentContainer' => $this->contentContainer]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('@bookmark/views/common/defaultConfig', [
            'model' => $model
        ]);
    }

    public function actionResetConfig()
    {
        $model = new DefaultSettings(['contentContainer' => $this->contentContainer]);
        $model->reset();
        $this->view->saved();
        return $this->render('@bookmark/views/common/defaultConfig', [
            'model' => $model
        ]);
    }
}