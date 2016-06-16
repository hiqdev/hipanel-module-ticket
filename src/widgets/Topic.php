<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use yii\helpers\Html;
use yii\jui\Widget;

class Topic extends Widget
{
    public $topics;

    private function _getColor($item)
    {
        $colors = [
           'general'   => 'label-default',
           'technical' => 'label-primary',
           'vds'       => 'label-info',
           'domain'    => 'label-success',
           'financial' => 'label-warning',
        ];

        return $colors[$item] ?: reset($colors);
    }

    public function run()
    {
        if ($this->topics) {
            $html = '';
            $html .= '<ul class="list-inline">';
            foreach ($this->topics as $item => $label) {
                $html .= Html::tag('li', '<span class="label ' . $this->_getColor($item) . '">' . $label . '</span>');
            }
            $html .= '</ul>';
            echo $html;
        }
    }
}
