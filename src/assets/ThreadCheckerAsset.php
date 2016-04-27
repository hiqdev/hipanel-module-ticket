<?php

namespace hipanel\modules\ticket\assets;

use yii\web\AssetBundle;

class ThreadCheckerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@hipanel/modules/ticket/assets';

    /**
     * @var array
     */
    public $js = [
        'js/threadChecker.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
