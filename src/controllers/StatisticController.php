<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\controllers;

use hipanel\actions\IndexAction;
use hipanel\modules\ticket\models\Statistic;
use hipanel\filters\EasyAccessControl;
use yii\base\Event;

class StatisticController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    '*' => 'manage',
                ],

            ],
        ]);
    }

    /**
     * @return array
     */
    protected function prepareRefs()
    {
        return [
            'topic_data' => $this->getRefs('topic,ticket', 'hipanel:ticket'),
            'state_data' => $this->getClassRefs('state', 'hipanel:ticket'),
            'priority_data' => $this->getRefs('type,priority', 'hipanel:ticket'),
        ];
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'data' => $this->prepareRefs(),
                'on beforePerform' => function (Event $event) {
                    $action = $event->sender;
                    $query = $action->getDataProvider()->query;
                    $representation = $action->controller->indexPageUiOptionsModel->representation;
                    if ($representation === 'consumers') {
                        $query->andWhere(['type' => 'consumers']);
                    } else {
                        $query->andWhere(['type' => 'performers']);
                    }
                }
            ],
        ]);
    }
}
