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
        ['class' => ProfileMenu::className(), 'event' => ProfileMenu::EVENT_INIT, 'callback' => ['humhub\modules\bookmark\Events', 'onProfileMenuInit']],
        ['class' => User::className(), 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\bookmark\Events', 'onUserDelete']],
        ['class' => ActiveRecord::className(), 'event' => ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\bookmark\Events', 'onActiveRecordDelete']],
        ['class' => IntegrityController::className(), 'event' => IntegrityController::EVENT_ON_RUN, 'callback' => ['humhub\modules\bookmark\Events', 'onIntegrityCheck']],
        ['class' => WallEntryLinks::className(), 'event' => WallEntryLinks::EVENT_INIT, 'callback' => ['humhub\modules\bookmark\Events', 'onWallEntryLinksInit']],
        ['class' => TopMenu::className(), 'event' => TopMenu::EVENT_INIT, 'callback' => ['\humhub\modules\bookmark\Events', 'onTopMenuInit']],
    ],
];
?>