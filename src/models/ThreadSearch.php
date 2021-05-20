<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
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

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'message_like' => Yii::t('hipanel:ticket', 'Message'),
            'anytext_like' => Yii::t('hipanel:ticket', 'Subject or 1st message'),
            'numbers' => Yii::t('hipanel:ticket', 'Ticket numbers separated by commas'),
            'hide_payment' => Yii::t('hipanel:ticket','Hide payment tickets'),
        ]);
    }

    protected function searchAttributes()
    {
        return array_merge($this->defaultSearchAttributes(), [
            'anytext_like', 'numbers', 'message_like',
            'hide_payment',
        ]);
    }
}
