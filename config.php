<?php

use humhub\components\ActiveRecord;
use humhub\commands\IntegrityController;
use humhub\widgets\TopMenu;
use humhub\modules\user\models\User;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\modules\content\widgets\WallEntryLinks;
use humhub\modules\bookmark\Events;
use humhub\modules\bookmark\Module;

return [
    'id' => 'bookmark',
    'class' => Module::class,
    'namespace' => 'humhub\modules\bookmark',
    'events' => [
        ['class' => ProfileMenu::class, 'event' => ProfileMenu::EVENT_INIT, 'callback' => [Events::class, 'onProfileMenuInit']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onUserDelete']],
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => [Events::class, 'onActiveRecordDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => [Events::class, 'onIntegrityCheck']],
        ['class' => WallEntryLinks::class, 'event' => WallEntryLinks::EVENT_INIT, 'callback' => [Events::class, 'onWallEntryLinksInit']],
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => [Events::class, 'onTopMenuInit']],
    ],
];
?>
