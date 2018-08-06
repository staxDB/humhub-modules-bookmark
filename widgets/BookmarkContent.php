<?php

namespace humhub\modules\bookmark\widgets;

use Yii;
use humhub\modules\stream\widgets\StreamViewer;
use humhub\components\Widget;
use humhub\modules\content\components\ContentContainerActiveRecord;

class BookmarkContent extends Widget
{
    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    public function run()
    {
        $messageStreamEmpty = Yii::t('BookmarkModule.views_index_index', '<b>You have not set a bookmark yet!</b><br>Search for content that interests you and bookmark it!');

        echo StreamViewer::widget([
            'streamAction' => '//bookmark/index/stream',
            'showFilters' => true,
            'messageStreamEmpty' => $messageStreamEmpty,
        ]);
    }
}
