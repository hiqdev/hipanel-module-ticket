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

use Yii;
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
            $html = '<ul class="list-inline">';
            foreach ($this->topics as $item => $label) {
                $label = Yii::t('hipanel:ticket', Html::encode($label));
                $html .= Html::tag('li', Html::tag('span', $label, ['class' => 'label ' . $this->_getColor($item)]));
            }
            $html .= '</ul>';
            echo $html;
        }
    }
}
