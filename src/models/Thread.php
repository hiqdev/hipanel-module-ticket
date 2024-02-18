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

use hipanel\behaviors\File;
use hipanel\helpers\Markdown;
use hipanel\modules\client\models\Client;
use stdClass;
use Yii;
use yii\helpers\HtmlPurifier;
use yii\web\NotFoundHttpException;

/**
 * Class Ticket.
 *
 * @property string $priority
 * @property string $responsible_id
 */
class Thread extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const DEFAULT_SHOW_ALL = 'all';

    public static $i18nDictionary = 'hipanel:ticket';

    const STATE_OPEN = 'opened';
    const STATE_CLOSE = 'closed';

    const PRIORITY_HIGH = 'high';

    public $search_form;

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
                'class' => File::class,
                'attribute' => 'file',
                'targetAttribute' => 'file_ids',
                'scenarios' => ['create', 'answer'],
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
            'spent', 'spent_hours',
            'answer_count',
            'status',
            'reply_time',
            'create_time',
            'a_reply_time',
            'elapsed',
            'topics',
            'topic',
            'watchers',
            'watcher_ids',
            'watcher',
            'watcher_id',
            'add_tag_ids',
            'file_ids',
            'file',
            'message', // 'answer_message',
            'is_private',

            'anonym_name',
            'anonym_email',
            'anonym_seller',

            'lastanswer',
            'time',
            'add_watchers', 'del_watchers',

            'time_from',
            'time_till',

            'contact',
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
            [['subject'], 'string', 'min' => 3],
            [['id'], 'required', 'on' => ['answer', 'update-answer', 'open', 'close']],
            [['recipient_id'], 'required', 'when' => function () {
                return Yii::$app->user->can('support');
            }, 'on' => 'create'],
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
                    'watchers', 'add_watchers', 'del_watchers', 'watcher_ids',
                    'is_private',
                    'file_ids',
                    'spent', 'spent_hours',
                ],
                'safe',
                'on' => 'answer',
            ],
            [['state'], 'safe', 'on' => ['close', 'open']],
            // only client-side validation. Answer is actually possible without a message,
            // but does not make any sense.
            [['message'], 'required', 'on' => ['answer'], 'when' => function () {
                return false;
            }],
            [['state'], 'default', 'value' => self::DEFAULT_SHOW_ALL, 'on' => ['default']],
            [['id'], 'integer', 'on' => 'answer'],
            [['file'], 'file', 'maxFiles' => 15],
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
            'author' => Yii::t('hipanel:ticket', 'Author'),
            'author_id' => Yii::t('hipanel:ticket', 'Author'),
            'recipient' => Yii::t('hipanel:ticket', 'Recipient'),
            'is_private' => Yii::t('hipanel:ticket', 'Make private'),
            'responsible' => Yii::t('hipanel:ticket', 'Responsible'),
            'responsible_id' => Yii::t('hipanel:ticket', 'Responsible'),
            'spent' => Yii::t('hipanel:ticket', 'Spent time'),
            'create_time' => Yii::t('hipanel:ticket', 'Created'),
            'a_reply_time' => Yii::t('hipanel:ticket', 'a_reply_time'),
            'file' => Yii::t('hipanel:ticket', 'Files'),
            'lastanswer' => Yii::t('hipanel:ticket', 'Last answer'),
            'author_seller' => Yii::t('hipanel:ticket', 'Seller'),
            'watcher_ids' => Yii::t('hipanel:ticket', 'Watchers'),
        ]);
    }

    public function getClient()
    {
        return $this->author;
    }

    public function getClient_id()
    {
        return $this->author_id;
    }

    public function getSeller()
    {
        return $this->author_seller;
    }

    public function getSeller_id()
    {
        return $this->author_seller_id;
    }

    public function getThreadUrlArray()
    {
        return ['@ticket/view', 'id' => $this->id];
    }

    public static function parseMessage($message)
    {
        $message = str_replace(["\n\r", "\r\r", "\r\n"], "\n", $message); // "\n\n",
        $message = Markdown::process($message);
        $message = HtmlPurifier::process($message, [
            'HTML.SafeObject' => true, // Allow safe HTML entities
            'Core.EscapeInvalidTags' => true, // Escape not allowed tags instead of stripping them
            'Core.LexerImpl' => 'DirectLex', // Do not try to close unclosed tags
        ]);

        return $message;
    }

    public function prepareSpentTime()
    {
        if (!empty($this->spent)) {
            [$this->spent_hours, $this->spent] = explode(':', $this->spent, 2);
        }
    }

    public function prepareTopic()
    {
        $this->topics = is_array($this->topics) ? implode(',', $this->topics) : $this->topics;
    }

    public function getWatchersLogin()
    {
        $results = [];
        foreach ((array)$this->watchers as $id => $watcher) {
            [$login, $email] = explode(' ', $watcher);
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

    public function getAnswers()
    {
        // TODO: redo API in order to have different `Thread` and `ThreadMessage` models
        return $this->hasMany(Answer::class, ['id' => 'id'])->joinWith('files')->indexBy('answer_id');
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

    /**
     * @param integer $id
     * @param bool $throwOnError whether to throw an exception when answer is not found in thread
     * @throws NotFoundHttpException
     * @return Answer
     */
    public function getAnswer($id, $throwOnError = true)
    {
        if (!isset($this->answers[$id]) && $throwOnError) {
            throw new NotFoundHttpException('Answer does not belong to this model');
        }

        return $this->answers[$id];
    }

    public function getMaxAnswerId()
    {
        if ($this->isRelationPopulated('answers')) {
            return max(array_keys($this->answers));
        }

        return $this->id;
    }

    public function scenarioActions()
    {
        return [
            'open' => 'answer',
            'close' => 'answer',
        ];
    }

    public function canSetSpent()
    {
        if (isset(Yii::$app->params['ticket.canSetSpent']) && is_callable(Yii::$app->params['ticket.canSetSpent'])) {
            return call_user_func(Yii::$app->params['ticket.canSetSpent'], $this);
        }

        return true;
    }

    public function isOpen()
    {
        return $this->state && $this->state !== self::STATE_CLOSE;
    }

    public function isHighPriority(): bool
    {
        return $this->priority === self::PRIORITY_HIGH;
    }

    public function isUserAssigned(): bool
    {
        return $this->responsible_id === Yii::$app->getUser()->getId();
    }
}
