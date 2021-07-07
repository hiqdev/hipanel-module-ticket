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

class Statistic extends Thread
{

    use \hipanel\base\ModelTrait;

    public static $i18nDictionary = 'hipanel:ticket';

    public static function tableName()
    {
        return 'threadstatistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'responsible_id', 'recipient_id', 'client_id', 'id', 'author_seller_id', 'replier_id', 'seller_id', 'client_seller_id'], 'integer'],
            [['answers_num', 'threads_num'], 'integer'],
            [['topics', 'state', 'priority', 'watchers','author_seller', 'replier', 'state_label', 'login'], 'safe'],
            [['spent', 'spent_hours', 'spend'], 'safe'],
            [['author','watchers','responsible','recipient', 'anytext_like', 'seller', 'client'], 'safe'],
            [['author_email'], 'email'],
            [['create_time','lastanswer','subject', 'reply_time','time_from','time_till', 'thread_ids'], 'safe'],
            [['answer_count'], 'integer'],
        ];
    }
}
