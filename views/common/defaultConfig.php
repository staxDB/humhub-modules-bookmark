<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */
/* @var $this yii\web\View */
/* @var $model \humhub\modules\bookmark\models\forms\DefaultSettings */

\humhub\modules\bookmark\assets\BookmarkAsset::register($this);

use humhub\modules\bookmark\widgets\ContainerConfigMenu;
use humhub\modules\bookmark\widgets\GlobalConfigMenu;
use humhub\widgets\ActiveForm;
use humhub\widgets\Button;
use yii\helpers\Url;

$helpBlock = $model->isGlobal()
    ? Yii::t('BookmarkModule.config', 'Here you can configure default settings for bookmark streams. These settings can be overwritten on profile level.')
    : Yii::t('BookmarkModule.config', 'Here you can configure default settings for your bookmark stream.');
$backUrl = $model->isGlobal()
? Url::to(['/admin/module'])
: Url::to(['/user/account/edit-modules']);
?>


<div class="panel panel-default">

    <div class="panel-heading"><?= Yii::t('BookmarkModule.forms', '<strong>Bookmark</strong> module configuration'); ?></div>

    <?php if ($model->isGlobal()) : ?>
        <?= GlobalConfigMenu::widget() ?>
    <?php else: ?>
        <?= ContainerConfigMenu::widget() ?>
    <?php endif; ?>

    <div class="panel-body" data-ui-widget="bookmark.Form">
        <?php $form = ActiveForm::begin(['action' => $model->getSubmitUrl()]); ?>
        <h4>
            <?= Yii::t('BookmarkModule.config', 'Default bookmark settings'); ?>
        </h4>

        <div class="help-block">
            <?= $helpBlock ?>
        </div>

        <div class="">
            <?= $form->field($model, 'pinned_first')->checkbox() ?>
        </div>

        <div class="">
            <?= $form->field($model, 'private_bookmarking')->checkbox() ?>
        </div>

        <?= Button::primary(Yii::t('base', 'Save'))->submit() ?>
        <?= Button::defaultType(Yii::t('BookmarkModule.forms', 'Back to modules'))->link($backUrl)->loader(false); ?>

        <?= \humhub\widgets\Link::defaultType(Yii::t('BookmarkModule.config', 'Reset'))->link($model->getResetButtonUrl())->loader(true)->options(['class' => 'pull-right']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
