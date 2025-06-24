<?php

declare(strict_types=1);
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use hipanel\base\SearchModelTrait;
use Yii;

/**
 * Class TicketSearch.
 */
class ThreadSearch extends Thread
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    protected function searchAttributes(): array
    {
        return array_merge($this->defaultSearchAttributes(), [
            'anytext_like',
            'numbers',
            'message_like',
            'hide_payment',
            'client_tags',
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'message_like' => Yii::t('hipanel:ticket', 'Message'),
            'anytext_like' => Yii::t('hipanel:ticket', 'Subject or 1st message or ticket number'),
            'numbers' => Yii::t('hipanel:ticket', 'Ticket numbers separated by commas'),
            'hide_payment' => Yii::t('hipanel:ticket', 'Hide payment tickets'),
            'client_tags' => Yii::t('hipanel:ticket', 'Client Tags'),
        ]);
    }
}
