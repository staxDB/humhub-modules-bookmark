<?php

use yii\helpers\Html;

humhub\modules\bookmark\assets\BookmarkAsset::register($this);
?>

<span class="bookmarkLinkContainer" id="bookmarkLinkContainer_<?= $id ?>">

    <?php if (Yii::$app->user->isGuest): ?>

        <?php echo Html::a(Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Bookmark'), Yii::$app->user->loginUrl, ['data-target' => '#globalModal']); ?>
    <?php else: ?>
        <a href="#" data-action-click="bookmark.toggleBookmark" data-action-url="<?= $bookmarkUrl ?>" class="bookmark bookmarkAnchor" style="<?= (!$currentUserBookmarked) ? '' : 'display:none'?>">
            <?= Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Bookmark') ?>
        </a>
        <a href="#" data-action-click="bookmark.toggleBookmark" data-action-url="<?= $unbookmarkUrl ?>" class="unbookmark bookmarkAnchor" style="<?= ($currentUserBookmarked) ? '' : 'display:none'?>">
            <?= Yii::t('BookmarkModule.widgets_views_bookmarkLink', '&checkmark; Bookmarked') ?>
        </a>
    <?php endif; ?>

    <?php if ($settings->seeBookmarkCount) : ?>
        <?php if (count($bookmarks) > 0) { ?>
            <!-- Create link to show all users, who bookmarked this -->
            <a href="<?php echo $userListUrl; ?>" data-target="#globalModal">
                <span class="bookmarkCount tt" data-placement="top" data-toggle="tooltip" title="<?= $title ?>">(<?= count($bookmarks) ?>)</span>
            </a>
        <?php } else { ?>
            <span class="bookmarkCount"></span>
        <?php } ?>
    <?php endif; ?>

</span>