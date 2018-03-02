<?php

namespace humhub\modules\bookmark\controllers;

use humhub\modules\bookmark\components\ProfileBookmarkStream;
use humhub\modules\bookmark\permissions\ViewBookmarkStream;
use Yii;
use yii\web\HttpException;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\bookmark\models\Bookmark;
use humhub\modules\bookmark\components\BookmarkStream;
use humhub\modules\stream\actions\Stream;


/**
 */
class ProfileController extends ContentContainerController
{

    public function actions()
    {
        return array(
            'stream' => array(
                'class' => ProfileBookmarkStream::className(),
                'mode' => ProfileBookmarkStream::MODE_NORMAL,
                'contentContainer' => $this->contentContainer
            ),
        );
    }

    /**
     * Returns a List of all bookmarked contents
     */
    public function actionShow()
    {
        if (!$this->contentContainer->permissionManager->can(new ViewBookmarkStream())) {
            throw new HttpException(403, 'Forbidden');
        }
        return $this->render('show', array(
            'contentContainer' => $this->contentContainer
        ));
    }

    /**
     * Reloads a single entry
     */
    public function actionReload()
    {
        Yii::$app->response->format = 'json';
        $id = Yii::$app->request->get('id');
        $model = Bookmark::findOne(['id' => $id]);

        if (!$model->content->canRead()) {
            throw new HttpException(403, Yii::t('BookmarkModule.base', 'Access denied!'));
        }

        return Stream::getContentResultEntry($model->content);
    }
}
