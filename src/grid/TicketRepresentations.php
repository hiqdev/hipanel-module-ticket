<?php

namespace hipanel\modules\ticket\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class TicketRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'subject',
                    'author_id',
                    'responsible_id',
                    'recipient_id',
                    'answer_count',
                ],
            ],
        ]);
    }
}
