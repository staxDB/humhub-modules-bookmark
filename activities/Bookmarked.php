<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\activities;

use Yii;
use humhub\modules\activity\components\BaseActivity;
use humhub\modules\activity\interfaces\ConfigurableActivityInterface;

/**
 * Bookmark Activity
 *
 * @author davidborn
 */
class Bookmarked extends BaseActivity implements ConfigurableActivityInterface
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'bookmark';

    /**
     * @inheritdoc
     */
    public $viewName = 'bookmarked';

    /**
     * @inheritdoc
     */
    public function getViewParams($params = array())
    {
        $bookmark = $this->source;
        $bookmarkSource = $bookmark->getSource();
        $params['preview'] = $this->getContentInfo($bookmarkSource);
        return parent::getViewParams($params);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('BookmarkModule.activities', 'Bookmarked');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('BookmarkModule.activities', 'Whenever someone bookmarked something (e.g. a post or comment).');
    }

}
