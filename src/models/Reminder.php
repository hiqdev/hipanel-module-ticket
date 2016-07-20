<?php

namespace hipanel\modules\ticket\models;

use Yii;

/**
 * Class Ticket(threads)
 */
class Reminder extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const REMAINDER_TYPE_SITE = 'site';

    const REMINDER_TYPE_MAIL = 'mail';

    public static function index()
    {
        return 'threads';
    }

    public static function type()
    {
        return 'thread';
    }

    public static $i18nDictionary = 'hipanel/ticket';

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'id',
            'periodicity',
            'from_time',
            'client',
            'message',
            'type',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'periodicity' => Yii::t('hipanel/ticket', 'Periodicity'),
            'from_time' => Yii::t('hipanel/ticket', 'When the recall?'),
            'client' => Yii::t('hipanel/ticket', 'Client'),
            'message' => Yii::t('hipanel/ticket', 'Message'),
            'type' => Yii::t('hipanel/ticket', 'Type'),
        ]);
    }

    public function getThread()
    {
        return $this->hasOne(Thread::class, ['id' => 'id']);
    }

    public function scenarioCommands()
    {
        return [
            'create' => 'notify-create',
            'answer' => 'notify-answer',
            'set-responsible' => 'notify-set-responsible',
        ];
    }
}
