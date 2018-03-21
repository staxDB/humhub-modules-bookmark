<?php

use yii\helpers\Html;

humhub\modules\bookmark\assets\BookmarkAsset::register($this);

$color = Html::encode($settings->iconColor);

$bookmarkText = '<span>';
$bookmarkText .= ($settings->showIcon) ? '<i class="fa fa-bookmark-o" style="margin-right: 3px;"></i>' : '';
$bookmarkText.= Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Set Bookmark');
$bookmarkText .= '</span>';

$unbookmarkText = '<span>';
$unbookmarkText .= ($settings->showIcon) ? '<i class="fa fa-bookmark" style="color:' . $color . '; margin-right: 3px;"></i>' : '';
$unbookmarkText.= Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Remove bookmark');
$unbookmarkText .= '</span>';

?>

<span class="bookmarkLinkContainer" id="bookmarkLinkContainer_<?= $id ?>">

    <?php if (Yii::$app->user->isGuest): ?>

        <?= Html::a(Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Bookmark'), Yii::$app->user->loginUrl, ['data-target' => '#globalModal']); ?>
    <?php else: ?>

        <?= Html::a($bookmarkText, '#', [
            'title' => Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Set Bookmark'),
            'data-action-click' => 'bookmark.toggleBookmark',
            'data-action-url' => $bookmarkUrl,
            'class' => 'bookmark bookmarkAnchor',
            'style' => ((!$currentUserBookmarked) ? '' : 'display:none')
        ]); ?>

        <?= Html::a($unbookmarkText, '#', [
            'title' => Yii::t('BookmarkModule.widgets_views_bookmarkLink', 'Remove bookmark'),
            'data-action-click' => 'bookmark.toggleBookmark',
            'data-action-url' => $unbookmarkUrl,
            'class' => 'unbookmark bookmarkAnchor',
            'style' => (($currentUserBookmarked) ? '' : 'display:none')
        ]); ?>
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