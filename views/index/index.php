<?php
/**
 * @var \humhub\modules\user\models\User $contentContainer
 */

?>

<?php if ($settings->showFullWidth) : ?>
<div class="container-fluid">
<?php else: ?>
<div class="container">
<?php endif; ?>

    <div class="row">
        <div class="col-md-8 layout-content-container">
            <?= \humhub\modules\bookmark\widgets\BookmarkContent::widget([
                'contentContainer' => $contentContainer,
            ])?>
        </div>
        <div class="col-md-4 layout-sidebar-container">
            <?php
            echo \humhub\modules\dashboard\widgets\Sidebar::widget([
                'widgets' => [
                    [
                        \humhub\modules\activity\widgets\Stream::className(),
                        ['streamAction' => '/dashboard/dashboard/stream'],
                        ['sortOrder' => 150]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
