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

use hipanel\models\File;
use Yii;

/**
 * Class Answer.
 *
 * @property Thread $thread
 */
class Answer extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public static $i18nDictionary = 'hipanel:ticket';

    public static function tableName()
    {
        return 'thread';
    }

    public function init()
    {
        $this->on(static::EVENT_BEFORE_INSERT, [$this, 'beforeChange']);
        $this->on(static::EVENT_BEFORE_UPDATE, [$this, 'beforeChange']);
    }

    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        $this->prepareSpentTime();

        return $result;
    }

    public function beforeChange($event)
    {
        $this->switchId();

        return true;
    }

    private function switchId()
    {
        if ($this->scenario === 'update') {
            $this->id = $this->answer_id;
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'hipanel\behaviors\File',
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
            'answer_id',
            'message',
            'private',
            'is_private',
            'is_answer',
            'changed_num',
            'author',
            'author_id',
            'author_seller',
            'seller_id',
            'account',
            'email_hash',
            'create_time',
            'spent',
            'spent_hours',
            'is_moved',
            'ip',
            'file',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['id', 'answer_id', 'spent', 'spent_hours'],
                'integer',
                'enableClientValidation' => false,
            ],
            [
                ['message', 'id', 'answer_id'],
                'required',
                'on' => 'update',
            ],
            [
                ['spent', '!spent_hours'],
                'safe',
                'on' => 'update',
            ],
            [
                ['is_private'],
                'boolean',
                'on' => 'update',
                'when' => function () {
                    return Yii::$app->user->can('support');
                },
            ],
        ];
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
            'responsible' => Yii::t('hipanel:ticket', 'Assignee'),
            'responsible_id' => Yii::t('hipanel:ticket', 'Assignee'),
            'spent' => Yii::t('hipanel:ticket', 'Spent time'),
            'create_time' => Yii::t('hipanel:ticket', 'Created'),
            'a_reply_time' => Yii::t('hipanel:ticket', 'a_reply_time'),
            'file' => Yii::t('hipanel:ticket', 'Files'),
            'lastanswer' => Yii::t('hipanel:ticket', 'Last answer'),
            'author_seller' => Yii::t('hipanel:ticket', 'Seller'),
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

    public function prepareSpentTime()
    {
        list($this->spent_hours, $this->spent) = explode(':', $this->spent, 2);
    }

    public function getThread()
    {
        return $this->hasOne(Thread::class, ['id' => 'id']);
    }

    public function getFiles()
    {
        return $this->hasMany(File::class, ['object_id' => 'id']);
    }

    public function scenarioActions()
    {
        return [
            'update' => 'update-answer',
        ];
    }

    public function canSetSpent()
    {
        return $this->thread->canSetSpent();
    }

    public function isOpen()
    {
        return $this->thread->isOpen();
    }
}
