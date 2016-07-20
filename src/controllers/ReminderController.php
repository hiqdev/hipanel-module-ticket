<?php

namespace hipanel\modules\ticket\controllers;

use hipanel\actions\RedirectAction;
use hipanel\actions\SmartPerformAction;
use Yii;

class ReminderController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'create' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'update',
                'success' => Yii::t('hipanel/ticket', 'Comment was updated'),
                'POST' => [
                    'save' => true,
                    'success' => [
                        'class' => RedirectAction::class,
                        'url' => function () {
                            $answer = Yii::$app->request->post('Answer');

                            return ['@ticket/view', 'id' => $answer['id']];
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function prepareRefs()
    {
        return [
            'topic_data' => $this->getRefs('topic,ticket', 'hipanel/ticket'),
            'state_data' => $this->getClassRefs('state', 'hipanel/ticket'),
            'priority_data' => $this->getPriorities(),
        ];
    }
}
