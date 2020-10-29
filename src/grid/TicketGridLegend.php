<?php


namespace hipanel\modules\ticket\grid;


use hipanel\modules\ticket\models\Thread;
use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

/**
 * Class TicketGridLegend
 * @package hipanel\modules\ticket\grid
 *
 * @property Thread $model
 */
class TicketGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:ticket', 'You assigned'),
                'color' => '#98FB98',
                'rule' => $this->model->isUserAssigned(),
            ],
            [
                'label' => Yii::t('hipanel:ticket', 'Priority'),
                'color' => '#F2DEDE',
                'rule' => $this->model->isHighPriority(),
            ],
        ];
    }
}
