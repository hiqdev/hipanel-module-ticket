<?php

namespace hipanel\modules\ticket\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class StatisticRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'consumers' => [
                'label' => Yii::t('hipanel:ticket', 'Consumers'),
                'columns' => [
                    'client_id', 'spent', 'tickets',
                ],
            ],
            'performers' => [
                 'label' => Yii::t('hipanel:ticket', 'Performers'),
                 'columns' => [
                    'client_id', 'spent', 'threads_num', 'answers_num', 'tickets',
                 ],
            ],
        ]);
    }
}
