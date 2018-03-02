<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\controllers;

use humhub\components\Controller;
use humhub\modules\bookmark\components\BookmarkStream;
use Yii;

class IndexController extends Controller
{
    public function init()
    {
        $this->appendPageTitle(\Yii::t('BookmarkModule.base', 'Bookmarks'));
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className(),
                'guestAllowedActions' => [
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'stream' => [
                'class' => BookmarkStream::className(),
                'mode' => BookmarkStream::MODE_NORMAL
            ]
        ];
    }

    /**
     * Bookmark Index
     *
     * Show recent wall entries for this user
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'contentContainer' => Yii::$app->user->getIdentity()
        ]);
    }

}
