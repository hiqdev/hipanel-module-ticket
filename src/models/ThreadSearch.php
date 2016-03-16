<?php

/*
 * Ticket Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use Yii;

/**
 * Class TicketSearch.
 */
class ThreadSearch extends Thread
{
    use \hipanel\base\SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    protected function searchAttributes()
    {
        return array_merge($this->defaultSearchAttributes(), [
            'anytext_like'
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'anytext_like' => Yii::t('hipanel/ticket', 'Subject or message'),
        ]);
    }
}
