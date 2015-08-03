<?php

/*
 * Ticket Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use common\components\Lang;
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
           'domain'    => 'label-success',
           'financial' => 'label-warning',
       ];
        if (array_key_exists($item, $colors)) {
            return $colors[$item];
        } else {
            return reset($colors);
        }
    }

    public function init()
    {
        parent::init();
        if ($this->topics) {
            $html = '';
            $html .= '<ul class="list-inline">';
            foreach ($this->topics as $item => $label) {
                $html .= Html::tag('li', '<span class="label ' . $this->_getColor($item) . '">' . Lang::l($label) . '</span>');
            }
            $html .= '</ul>';
            print $html;
        }
    }
}
