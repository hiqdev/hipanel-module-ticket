<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use hipanel\modules\client\models\Client;
use stdClass;
use Yii;
use yii\helpers\Html as Html;
use yii\helpers\Markdown as Markdown;

/**
 * Class Ticket.
 */
class Thread extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public static $i18nDictionary = 'hipanel/ticket';

    const STATE_OPEN = 'opened';
    const STATE_CLOSE = 'closed';

    public $search_form;

    public $answer_spent;

    public function init()
    {
        $this->on(static::EVENT_BEFORE_INSERT, [$this, 'beforeChange']);
        $this->on(static::EVENT_BEFORE_UPDATE, [$this, 'beforeChange']);
    }

    public function beforeChange($event)
    {
        $this->prepareSpentTime();
        $this->prepareTopic();

        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class'          => 'common\behaviors\File',
                'attribute'      => 'file',
                'savedAttribute' => 'file_ids',
                'scenarios'      => ['create', 'answer'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'id',
            'subject',
            'state',
            'state_label',
            'author_email',
            'author',
            'author_id',
            'responsible_id',
            'responsible_email',
            'author_seller',
            'author_seller_id',
            'recipient_id',
            'recipient',
            'recipient_seller',
            'recipient_seller_id',
            'replier_id',
            'replier',
            'replier_seller',
            'replier_name',
            'responsible',
            'priority',
            'priority_label',
            'spent', 'answer_spent', 'spent_hours',
            'answer_count',
            'status',
            'reply_time',
            'create_time',
            'a_reply_time',
            'elapsed',
            'topics',
            'topic',
            'watchers',
            'watcher',
            'add_tag_ids',
            'file_ids',
            'file',
            'message', // 'answer_message',
            'answers',
            'is_private',

            'anonym_name',
            'anonym_email',
            'anonym_seller',

            'lastanswer',
            'time',
            'add_watchers', 'del_watchers',

            'time_from',
            'time_till',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['author_id', 'responsible_id'], 'integer'],
            [['subject', 'message'], 'required', 'on' => ['create']],
            [['id'], 'required', 'on' => ['answer']],
            [
                [
                    'topics',
                    'state',
                    'priority',
                    'responsible',
                    'recipient_id',
                    'watchers',
                    'spent', 'spent_hours',
                    'file_ids',
                ],
                'safe',
                'on' => 'create',
            ],
            [
                [
                    'message',
                    'topics', 'state', 'priority',
                    'responsible', 'recipient_id',
                    'watchers', 'add_watchers', 'del_watchers',
                    'is_private',
                    'file_ids',
                    'answer_spent', 'spent', 'spent_hours',
                ],
                'safe',
                'on' => 'answer',
            ],
            [['id'], 'integer', 'on' => 'answer'],
            [['file'], 'file', 'maxFiles' => 5],
            [['lastanswer', 'create_time', 'recipient'], 'safe'],
            [['author', 'author_seller'], 'safe', 'when' => Yii::$app->user->can('support')],
        ];

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'author'           => Yii::t('hipanel/ticket', 'Author'),
            'author_id'        => Yii::t('hipanel/ticket', 'Author'),
            'recipient'        => Yii::t('hipanel/ticket', 'Recipient'),
            'is_private'       => Yii::t('hipanel/ticket', 'Make private'),
            'responsible'      => Yii::t('hipanel/ticket', 'Assignee'),
            'responsible_id'   => Yii::t('hipanel/ticket', 'Assignee'),
            'spent'            => Yii::t('hipanel/ticket', 'Spent time'),
            'create_time'      => Yii::t('hipanel/ticket', 'Created'),
            'a_reply_time'     => Yii::t('hipanel/ticket', 'a_reply_time'),
            'file'             => Yii::t('hipanel/ticket', 'Files'),
            'lastanswer'       => Yii::t('hipanel/ticket', 'Last answer'),
            'author_seller'    => Yii::t('hipanel/ticket', 'Author\'s seller'),
        ]);
    }

    public function getClient()
    {
        return $this->author;
    }

    public function getClientId()
    {
        return $this->author_id;
    }

    public function getSeller()
    {
        return $this->author_seller;
    }

    public function getSellerId()
    {
        return $this->author_seller_id;
    }

    public function getThreadUrl()
    {
        return ['/ticket/ticket/view', 'id' => $this->id];
    }

    public function getThreadViewTitle()
    {
        return '#' . $this->id . ' ' . Html::encode($this->subject);
    }

    public static function regexConfig($target)
    {
        $config = [
            'ticket' => ['/\#\d{6,9}(\#answer-\d{6,7})?\b/'],
            'server' => ['/\b[A-Z]*DS\d{3,9}[A-Za-z0-9-]{0,6}\b/'],
        ];

        return $config[$target];
    }

    public static function prepareLinks($text)
    {
        $targets = ['ticket', 'server'];
        $host    = getenv('HTTP_HOST');
        foreach ($targets as $target) {
            foreach (self::regexConfig($target) as $pattern) {
                $matches = [];
                $changed = [];
                preg_match_all($pattern, $text, $matches);
                foreach ($matches[0] as $match) {
                    $number = $target === 'tickets' ? substr($match, 1) : $match;
                    if ($changed[$number] && $changed[$number] === $match) {
                        continue;
                    }
                    $changed[$number] = $match;
                    $text             = str_replace($match, "[[https://{$host}/panel/{$target}/details/{$number}|{$match}]]", $text);
                }
            }
        }

        return $text;
    }

    public static function parseMessage($message)
    {
        //        $message = Html::encode($message); // prevent xss
        $message = str_replace(["\n\r", "\r\r", "\r\n"], "\n", $message); // "\n\n",
        // $message = self::prepareLinks($message);
        $message = Markdown::process($message);

        return $message;
    }

    public function prepareSpentTime()
    {
        list($this->spent_hours, $this->spent) = explode(':', $this->isNewRecord ? $this->spent : $this->answer_spent, 2);
    }

    public function prepareTopic()
    {
        $this->topics = is_array($this->topics) ? implode(',', $this->topics) : $this->topics;
    }

    public function afterFind()
    {
        //        if (is_array($this->topics)) $this->topics = array_keys($this->topics);
//        if (is_array($this->watchers)) $this->watchers = array_keys($this->watchers);

        parent::afterFind();
    }

    public function scenarioCommands()
    {
        return [
            'create' => 'create',
        ];
    }

    public function getWatchersLogin()
    {
        $results = [];
        foreach ((array) $this->watchers as $id => $watcher) {
            list($login, $email) = explode(' ', $watcher);
            $results[$id] = $login;
        }
        return $results;
    }

    public function xFormater(array $items)
    {
        $result = [];
        foreach ($items as $id => $label) {
            $object = new stdClass();
            $object->value = $id;
            $object->text = $label;
            $result[] = $object;
        }
        return $result;
    }

    /**
     * Returns array of client types, that can be set as responsible for the thread.
     *
     * @return array
     */
    public static function getResponsibleClientTypes()
    {
        return [Client::TYPE_SELLER, Client::TYPE_ADMIN, Client::TYPE_MANAGER, Client::TYPE_OWNER];
    }
}
