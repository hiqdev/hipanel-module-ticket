<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\modules\ticket\models\Template;
use hiqdev\hiart\Collection;
use hiqdev\hiart\ErrorResponseException;
use hisite\modules\news\models\ArticleData;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class TemplateController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '@ticket/template/index',
                ],
            ],
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function (Event $event) {
                    $dataProvider = $event->sender->getDataProvider();
                    $dataProvider->query->showUnpublished();
                },
            ],
            'search' => [
                'class' => SearchAction::class,
                'on beforePerform' => function (Event $event) {
                    $dataProvider = $event->sender->getDataProvider();
                    $dataProvider->query->joinWith('texts');
                },
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('texts')->showUnpublished();
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Template was created successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to create a template'),
                'data' => function ($action, $data = []) {
                    /** @var Template $model */
                    foreach ($data['models'] as $model) {
                        if (empty($model->getAddedTexts())) {
                            if (empty($model->texts)) {
                                $langs = $this->getRefs('type,lang', 'hipanel');
                                foreach ($langs as $code => $lang) {
                                    $model->addText(new ArticleData([
                                        'lang' => $code,
                                        'scenario' => 'create',
                                    ]));
                                }
                            } else {
                                $model->setAddedTexts($model->texts);
                            }
                        }
                    }
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'on beforeFetchLoad' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('texts')->showUnpublished();
                },
                'data' => function ($action, $data = []) {
                    /** @var Template $model */
                    foreach ($data['models'] as $model) {
                        if (empty($model->getAddedTexts())) {
                            if (empty($model->texts)) {
                                $model->addText(new ArticleData(['scenario' => 'create']));
                            } else {
                                $model->setAddedTexts($model->texts);
                            }
                        }
                    }
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
                'success' => Yii::t('hipanel:hosting', 'Template was updated successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to update a template'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Template was deleted successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to delete a template'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ];
    }

    public function actionText($id, $lang)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = [];

        try {
            $template = Template::find()->joinWith('texts')->andWhere(['id' => $id])->one();
        } catch (ErrorResponseException $e) {
            return [];
        }

        if (isset($template->texts)) {
            foreach ($template->texts as $text) {
                if ($text->lang === $lang) {
                    $result['text'] = $text->text;
                }
            }
        }

        return $result;
    }

    public function collectionLoader($scenario, Collection $collection)
    {
        $templateModel = $this->newModel(['scenario' => $scenario]);
        $articleDataModel = new ArticleData(['scenario' => $scenario]);

        $templateModels = [$templateModel];
        for ($i = 1; $i < count(Yii::$app->request->post($templateModel->formName(), [])); ++$i) {
            $templateModels[] = clone $templateModel;
        }

        if (Template::loadMultiple($templateModels, Yii::$app->request->post())) {
            /** @var Template $template */
            foreach ($templateModels as $i => $template) {
                $articleDataModels = [$articleDataModel];
                $texts = ArrayHelper::getValue(Yii::$app->request->post($articleDataModel->formName(), []), $i, []);
                for ($i = 1; $i < count($texts); ++$i) {
                    $articleDataModels[] = clone $articleDataModel;
                }
                ArticleData::loadMultiple($articleDataModels, [$articleDataModel->formName() => $texts]);

                /** @var ArticleData $text */
                foreach ($articleDataModels as $text) {
                    if ($text->article_id === $template->id && $text->validate()) {
                        $template->addText($text);
                    }
                }
            }

            $collection->set($templateModels);
        }
    }
}
