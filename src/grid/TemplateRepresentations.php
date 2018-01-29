<?php

namespace hipanel\modules\ticket\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class TemplateRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'author_id',
                    'name',
                    'actions',
                    'is_published',
                ],
            ],
        ]);
    }
}
