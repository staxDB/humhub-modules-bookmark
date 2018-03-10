<?php

namespace humhub\modules\bookmark\models\forms;

use Yii;
use \yii\base\Model;

class ConfigForm extends Model
{
    public $seeBookmarkCount = false;
    public $showFullWidth = true;
    public $showPinnedFirst = false;

    /**
     * @inheritdocs
     */
    public function init()
    {
        $settings = Yii::$app->getModule('bookmark')->settings;
        $this->seeBookmarkCount = $settings->get('seeBookmarkCount', $this->seeBookmarkCount);
        $this->showFullWidth = $settings->get('showFullWidth', $this->showFullWidth);
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
            [['seeBookmarkCount', 'showFullWidth'],  'boolean'],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'seeBookmarkCount' => Yii::t('BookmarkModule.forms', 'Show Bookmark-Count in braces.'),
            'showFullWidth' => Yii::t('BookmarkModule.forms', 'Show global Bookmark-View in full width.'),
        );
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
        $this->seeBookmarkCount = $settings->set('seeBookmarkCount', $this->seeBookmarkCount);
        $this->showFullWidth = $settings->set('showFullWidth', $this->showFullWidth);
        return true;
    }

}
