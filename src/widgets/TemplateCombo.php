<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;

class TemplateCombo extends Combo
{
    /** @inheritdoc */
    public $name = 'template';

    /** @inheritdoc */
    public $type = 'ticket/template';

    /** @inheritdoc */
    public $url = '@ticket/template/search';

    /** @inheritdoc */
    public $_return = ['id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'name'];

    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'select2Options' => [
                'minimumResultsForSearch' => -1,
            ]
        ]);
    }
}
