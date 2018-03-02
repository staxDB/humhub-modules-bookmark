<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\bookmark\assets;

use yii\web\AssetBundle;

/**
 * Assets for bookmark related resources.
 * 
 * @since 1.2
 * @author davidborn
 */
class BookmarkAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bookmark/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.bookmark.js'
    ];

}
