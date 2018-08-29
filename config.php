<?php

use humhub\components\ActiveRecord;
use humhub\commands\IntegrityController;
use humhub\widgets\TopMenu;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Membership;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\modules\content\widgets\WallEntryLinks;

return [
    'id' => 'bookmark',
    'class' => 'humhub\modules\bookmark\Module',
    'namespace' => 'humhub\modules\bookmark',
    'events' => [
        ['class' => ProfileMenu::class, 'event' => ProfileMenu::EVENT_INIT, 'callback' => ['humhub\modules\bookmark\Events', 'onProfileMenuInit']],
        ['class' => User::class, 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\bookmark\Events', 'onUserDelete']],
        ['class' => ActiveRecord::class, 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\bookmark\Events', 'onActiveRecordDelete']],
        ['class' => IntegrityController::class, 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => ['humhub\modules\bookmark\Events', 'onIntegrityCheck']],
        ['class' => WallEntryLinks::class, 'event' => WallEntryLinks::EVENT_INIT, 'callback' => ['humhub\modules\bookmark\Events', 'onWallEntryLinksInit']],
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => ['\humhub\modules\bookmark\Events', 'onTopMenuInit']],
    ],
];
?>
