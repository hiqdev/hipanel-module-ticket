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

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\modules\ticket\models\Statistic;
use hiqdev\hiart\Collection;
use hiqdev\hiart\ResponseErrorException;
use hisite\modules\news\models\ArticleData;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class StatisticController extends \hipanel\base\CrudController
{
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
        return [
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
        ];
    }
}
