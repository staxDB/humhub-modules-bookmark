<?php
/**
 * @var \humhub\modules\user\models\User $contentContainer
 */
use humhub\modules\bookmark\widgets\BookmarkContent;
use humhub\modules\dashboard\widgets\Sidebar;
use humhub\modules\activity\widgets\Stream;

?>

<?php if ($settings->showFullWidth) : ?>
<div class="container-fluid">
<?php else: ?>
<div class="container">
<?php endif; ?>

    <div class="row">
        <div class="col-md-8 layout-content-container">
            <?= BookmarkContent::widget([
                'contentContainer' => $contentContainer,
            ])?>
        </div>
        <div class="col-md-4 layout-sidebar-container">
            <?= Sidebar::widget([
                'widgets' => [
                    [
                        Stream::className(),
                        ['streamAction' => '/dashboard/dashboard/stream'],
                        ['sortOrder' => 150]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
