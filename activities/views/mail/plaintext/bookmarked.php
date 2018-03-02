<?php

use yii\helpers\Html;

echo strip_tags(Yii::t('BookmarkModule.views_activities_Bookmark', '{userDisplayName} bookmarked {contentTitle}', array(
    '{userDisplayName}' => Html::encode($originator->displayName),
    '{contentTitle}' => $preview,
)));
?>
