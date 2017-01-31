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

use yii\helpers\Html;
use yii\jui\Widget;

class Label extends Widget
{
    public $rules = [
        'priority' => ['medium' => 'info', 'high' => 'warning'],
        'state'    => ['opened' => 'success'],
    ];

    public $label;

    public $value;

    public $type;

    public $defaultCssClass = 'default';

    public function init()
    {
        parent::init();
        echo Html::tag('span', $this->label, ['class' => 'label label-' . $this->cssClasses()]);
    }

    protected function cssClasses()
    {
        $t = mb_strtolower($this->type);
        $v = mb_strtolower($this->value);

        return (array_key_exists($v, $this->rules[$t])) ? $this->rules[$t][$v] : $this->defaultCssClass;
    }
}
