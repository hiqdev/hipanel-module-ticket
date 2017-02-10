<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use hiqdev\combo\Combo;
use yii\web\JsExpression;

class TemplateCombo extends Combo
{
    /** {@inheritdoc} */
    public $name = 'template';

    /** {@inheritdoc} */
    public $type = 'ticket/template';

    /** {@inheritdoc} */
    public $url = '@ticket/template/search';

    /** {@inheritdoc} */
    public $_return = ['id'];

    /** {@inheritdoc} */
    public $_rename = ['text' => 'name'];

    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'select2Options' => [
                'minimumResultsForSearch' => new JsExpression('Infinity'),
            ],
        ]);
    }
}
