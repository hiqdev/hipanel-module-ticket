<?php declare(strict_types=1);
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\forms;

use DateTimeImmutable;
use Yii;
use yii\base\Model;

/**
 * Filters for the ticket export (the hiapi `ticketsExport` command).
 *
 * The name ends in "Search" on purpose: TagsInput only submits its value for models whose
 * form name contains "Search" (see TagsInput::isAsync()).
 */
class TicketExportSearch extends Model
{
    public const STATUS_ALL = 'all';
    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    /** Ticket states (`state,ticket,*` refs) behind each status option. */
    private const STATES = [
        self::STATUS_OPEN => ['opened', 'progress', 'passed', 'waiting'],
        self::STATUS_CLOSED => ['closed'],
    ];

    private const DATE_FORMAT = 'Y-m-d';

    public ?string $time_from = null;
    public ?string $time_till = null;
    public string $status = self::STATUS_ALL;
    public $topics = [];
    public ?string $client_tags = null;

    public function init(): void
    {
        parent::init();
        $this->time_till ??= date(self::DATE_FORMAT);
    }

    public function rules(): array
    {
        return [
            [['time_from', 'time_till'], 'required'],
            [['time_from', 'time_till'], 'date', 'format' => 'php:' . self::DATE_FORMAT],
            ['time_till', 'compare', 'compareAttribute' => 'time_from', 'operator' => '>=', 'type' => 'date'],
            ['status', 'in', 'range' => array_keys($this->statusOptions())],
            ['topics', 'each', 'rule' => ['string']],
            ['client_tags', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'time_from' => Yii::t('hipanel:ticket', 'Period'),
            'time_till' => Yii::t('hipanel:ticket', 'Period'),
            'status' => Yii::t('hipanel:ticket', 'Status'),
            'topics' => Yii::t('hipanel:ticket', 'Topics'),
            'client_tags' => Yii::t('hipanel:ticket', 'Client Tags'),
        ];
    }

    public function statusOptions(): array
    {
        return [
            self::STATUS_ALL => Yii::t('hipanel:ticket', 'All'),
            self::STATUS_OPEN => Yii::t('hipanel:ticket', 'Open'),
            self::STATUS_CLOSED => Yii::t('hipanel:ticket', 'Closed'),
        ];
    }

    /**
     * The period is inclusive here, but the API's time_till is exclusive
     * (create_time < time_till), so the day after the chosen end date is sent.
     */
    public function toApiParams(): array
    {
        $params = [
            'time_from' => $this->time_from,
            'time_till' => (new DateTimeImmutable($this->time_till))->modify('+1 day')->format(self::DATE_FORMAT),
        ];
        if (isset(self::STATES[$this->status])) {
            $params['states'] = implode(',', self::STATES[$this->status]);
        }
        if (!empty($this->topics)) {
            $params['topics'] = implode(',', (array)$this->topics);
        }
        if (!empty($this->client_tags)) {
            $params['client_tags'] = $this->client_tags;
        }

        return $params;
    }

    public function fileName(): string
    {
        return "tickets_{$this->time_from}_{$this->time_till}.json";
    }
}
