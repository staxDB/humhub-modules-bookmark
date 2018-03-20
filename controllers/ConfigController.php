<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\controllers;

use Yii;
use yii\helpers\Url;
use humhub\modules\admin\permissions\ManageModules;
use humhub\modules\admin\components\Controller;
use humhub\modules\bookmark\models\forms\ConfigForm;
use humhub\modules\bookmark\models\forms\DefaultSettings;

/**
 * 
 */
class ConfigController extends Controller
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
        return [['permissions' => ManageModules::class]];
    }

    public function actionIndex()
    {
        $model = new DefaultSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('@bookmark/views/common/defaultConfig', [
            'model' => $model
        ]);
    }

    public function actionResetConfig()
    {
        $model = new DefaultSettings();
        $model->reset();
        $this->view->saved();
        return $this->render('@bookmark/views/common/defaultConfig', [
            'model' => $model
        ]);
    }

    public function actionConfig()
    {
        $model = new ConfigForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('@bookmark/views/config/config', [
            'model' => $model
        ]);
    }
}
