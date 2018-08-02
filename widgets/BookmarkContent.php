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
//            'showFilters' => false,
            'messageStreamEmpty' => $messageStreamEmpty,
//            'filters' => [
//                'filter_entry_files' => Yii::t('ContentModule.widgets_views_stream', 'Content with attached files'),
//                'filter_entry_mine' => Yii::t('ContentModule.widgets_views_stream', 'Created by me'),
//                'filter_entry_archived' => Yii::t('ContentModule.widgets_views_stream', 'Include archived posts'),
//                'filter_visibility_public' => Yii::t('ContentModule.widgets_views_stream', 'Only public posts'),
//                'filter_visibility_private' => Yii::t('ContentModule.widgets_views_stream', 'Only private posts')
//            ]
        ]);
    }
}
