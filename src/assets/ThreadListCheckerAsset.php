<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\assets;

use yii\web\AssetBundle;

class ThreadListCheckerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@hipanel/modules/ticket/assets';

    /**
     * @var array
     */
    public $js = [
        'js/threadListChecker.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        \yii\web\JqueryAsset::class,
        \hiqdev\assets\visibilityjs\VisibilityjsAsset::class,
    ];
}
