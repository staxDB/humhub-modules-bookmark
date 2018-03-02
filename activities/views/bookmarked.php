<?php

use yii\helpers\Html;

echo Yii::t('BookmarkModule.views_activities_Bookmark', '{userDisplayName} bookmarked {contentTitle}', array(
    '{userDisplayName}' => '<strong>' . Html::encode($originator->displayName) . '</strong>',
    '{contentTitle}' => $preview,
));
?>
