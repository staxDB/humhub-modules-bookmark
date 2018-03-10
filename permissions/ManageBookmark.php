<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\permissions;

use Yii;
use humhub\modules\user\models\User;

/**
 * ViewBookmarkStream Permission
 */
class ManageBookmark extends \humhub\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        User::USERGROUP_SELF,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        User::USERGROUP_SELF
    ];

    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->title = Yii::t('BookmarkModule.permissions', 'Manage Bookmark');
        $this->description = Yii::t('BookmarkModule.permissions', 'Can manage Bookmark entries.');
    }

    /**
     * @inheritdoc
     */
    protected $title;

    /**
     * @inheritdoc
     */
    protected $description;

    /**
     * @inheritdoc
     */
    protected $moduleId = 'bookmark';

}
