<?php declare(strict_types=1);
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use hipanel\models\Ref;
use hisite\modules\news\models\Article;
use Yii;
use yii\base\Event;
use yii\helpers\Json;

/**
 *
 * @property-read array $topicOptions
 * @property-read array $priorityOptions
 */
class Template extends Article
{
    public static $i18nDictionary = 'hipanel:ticket';

    public static function tableName()
    {
        return 'article';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['responsible', 'priority', 'topics']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['responsible', 'priority', 'topics', 'data'], 'safe'],
        ]);
    }

    public function init()
    {
        $this->realm = 'ticket_template';
        $this->type = 'default';
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'prepareData']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'prepareData']);
        $this->on(self::EVENT_AFTER_FIND, [$this, 'prepareData']);
    }

    public static function find($options = [])
    {
        return parent::find($options)->andWhere([
            'realm' => 'ticket_template',
        ]);
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name' => Yii::t('hipanel:ticket', 'Name'),
            'responsible' => Yii::t('hipanel:ticket', 'Responsible'),
            'priority' => Yii::t('hipanel:ticket', 'Priority'),
            'topics' => Yii::t('hipanel:ticket', 'Topic'),
        ]);
    }

    public function getTopicOptions(): array
    {
        return Ref::getList('topic,ticket', self::$i18nDictionary);
    }

    public function getPriorityOptions(): array
    {
        return Ref::getList('type,priority', self::$i18nDictionary);
    }

    public function prepareData(Event $event): void
    {
        $sender = $event->sender;
        if ($event->name === self::EVENT_AFTER_FIND) {
            $data = Json::decode($sender->data) ?? [];
            foreach ($data as $key => $value) {
                $sender->$key = $value;
            }
        } else {
            $sender->data = Json::encode(array_filter([
                'responsible' => $sender->responsible,
                'priority' => $sender->priority,
                'topics' => $sender->topics,
            ]));
        }
    }
}
