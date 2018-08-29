<?php

namespace humhub\modules\bookmark\models\forms;

use Yii;
use \yii\base\Model;

class ConfigForm extends Model
{
    /**
     * @var boolean determines if the bookmark count should be shown or not (default false)
     */
    public $seeBookmarkCount = false;

    /**
     * @var boolean determines if the bookmark stream should be shown in full width or not (default true)
     */
    public $showFullWidth = true;

    /**
     * @var boolean determines if an icon should be shown in or not (default false)
     */
    public $showIcon = false;

    /**
     * @var int defines the addOn sort order
     */
    public $sortOrder = 10;

    /**
     * @var int defines the addOn sort order
     */
    public $iconColor = '#F4778E';

    /**
     * @inheritdocs
     */
    public function init()
    {
        $settings = Yii::$app->getModule('bookmark')->settings;
        $this->seeBookmarkCount = $settings->get('seeBookmarkCount', $this->seeBookmarkCount);
        $this->showFullWidth = $settings->get('showFullWidth', $this->showFullWidth);
        $this->showIcon = $settings->get('showIcon', $this->showIcon);
        $this->sortOrder = $settings->get('sortOrder', $this->sortOrder);
        $this->iconColor = $settings->get('iconColor', $this->iconColor);
    }


    /**
     * Static initializer
     * @return \self
     */
    public static function instantiate()
    {
        return new self;
    }
    
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [['iconColor', 'seeBookmarkCount', 'showFullWidth', 'showIcon', 'sortOrder'], 'required'],
            [['seeBookmarkCount', 'showFullWidth', 'showIcon'],  'boolean'],
            [['iconColor'],  'string'],
            ['sortOrder',  'number', 'min' => 0],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return [
            'seeBookmarkCount' => Yii::t('BookmarkModule.forms', 'Show Bookmark-Count in braces.'),
            'showFullWidth' => Yii::t('BookmarkModule.forms', 'Show global Bookmark-View in full width.'),
            'showIcon' => Yii::t('BookmarkModule.forms', 'Show an icon for each entry.'),
            'iconColor' => Yii::t('BookmarkModule.forms', 'Icon color'),
            'sortOrder' => Yii::t('BookmarkModule.forms', 'Sort order'),
        ];
    }
    
    /**
     * Saves the given form settings.
     */
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }

        $settings = Yii::$app->getModule('bookmark')->settings;
        $settings->set('seeBookmarkCount', $this->seeBookmarkCount);
        $settings->set('showFullWidth', $this->showFullWidth);
        $settings->set('showIcon', $this->showIcon);
        $settings->set('iconColor', $this->iconColor);
        $settings->set('sortOrder', $this->sortOrder);

        return true;
    }

}
