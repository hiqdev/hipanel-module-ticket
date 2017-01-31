<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace frontend\modules\ticket\widgets;

use yii\helpers\Html;
use yii\jui\Widget;

class Watcher extends Widget
{
    public $inView = true;

    public $watchers = [];

    public function init()
    {
        parent::init();
        if ($this->inView and is_array($this->watchers)) {
            echo Html::beginTag('ul', ['class' => 'list-unstyled']);
            foreach ($this->watchers as $uid => $username) {
                echo Html::beginTag('li');
                echo Html::a($username, ['/client/client/view', 'id' => $uid]);
                echo Html::endTag('li');
            }
            echo Html::endTag('ul');
        }
    }

    protected function cssClasses()
    {
        $t = mb_strtolower($this->type);
        $v = mb_strtolower($this->value);

        return (array_key_exists($v, $this->rules[$t])) ? $this->rules[$t][$v] : $this->defaultCssClass;
    }
}
