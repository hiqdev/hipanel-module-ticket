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
                    'login', 'spend', 'tickets',
                ],
            ],
            'Performers' => [
                 'label' => Yii::t('hipanel:ticket', 'Performers'),
                 'columns' => [
                    'login', 'spend', 'tickets',
                 ],
            ],
        ]);
    }
}
