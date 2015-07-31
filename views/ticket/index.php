<?php
/**
 * @link    http://hiqdev.com/hipanel-module-ticket
 * @license http://hiqdev.com/hipanel-module-ticket/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\widgets\Gravatar;
use hipanel\grid\ActionColumn;
use hipanel\grid\GridView;
use hipanel\widgets\ActionBox;
//use hipanel\widgets\Select2;
use hipanel\modules\ticket\widgets\Topic;
use yii\helpers\Html;
use yii\helpers\Url;
use hipanel\widgets\Box;

$this->title = Yii::t('app', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

$this->registerCss(<<<CSS
.list-inline {
    display: inline-block;
    padding-left: .5em;
    margin-bottom: 5px;
}

.table-list-cell {
  position: relative;
  display: table-cell;
  padding: 0px 10px;
  vertical-align: top;
}

.table-list-cell-type {
  padding-top: 15px;
  padding-left: 0;
  padding-right: 0;
  width: 20px;
  text-align: center;
}

.table-list-title {
  width: 740px;
  padding-top: 12px;
}
CSS
);
?>

<?php $box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]) ?>
<?php $box->beginActions(); ?>
    <?= Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'Ticket']), ['create'], ['class' => 'btn btn-primary']) ?>
    &nbsp;
    <?= Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-info search-button']) ?>
    &nbsp;
    <?=  \hipanel\widgets\LinkSorter::widget([
        'show' => true,
        'sort' => $sort,
        'attributes' => [
            'create_time',
            'lastanswer',
            'time',
            'subject',
            'spent',
            'author',
            'recipient',
        ]
    ]); ?>
<?php $box->endActions(); ?>
<?php $box->beginBulkActions(); ?>
    <?= Html::a(Yii::t('app', 'Subscribe'), ['create'], ['class' => 'btn btn-primary']) ?>
    &nbsp;
    <?= Html::a(Yii::t('app', 'Unsubscribe'), ['create'], ['class' => 'btn btn-primary']) ?>
    &nbsp;
    <?= Html::a(Yii::t('app', 'Close'), ['create'], ['class' => 'btn btn-danger']) ?>

<?php $box->endBulkActions(); ?>

<?= $this->render('_search', compact('model', 'topic_data', 'priority_data', 'state_data')) ?>
<?php $box::end(); ?>

<?php $box = Box::begin(['renderBody' => false, 'options' => ['class' => 'box-primary']]); ?>
<?php $box->beginBody(); ?>
<?= GridView::widget([
//    'sorter' => [
//        'class' => '\hipanel\widgets\LinkSorter',
//        'show' => true,
//        'sort' => $sort,
//        'attributes' => [
//            'create_time',
//            'lastanswer',
//            'time',
//            'subject',
//            'spent',
//            'author',
//            'recipient',
//        ]
//    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'id' => 'ticket-grid',
    'striped' => false,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['class' => ($model['priority'] == 'high') ? 'bg-danger' : ''];
    },
    'columns' => [
        [
            'attribute' => 'subject',
            'format' => 'raw',
            'value' => function ($data) {
                $state = $data->state == 'opened' ?
                    Html::tag('div', '<span class="fa fa-circle-o text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type']) :
                    Html::tag('div', '<span class="fa fa-check-circle text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type']);
                $t = Html::tag('b', Html::a($data->subject, $data->threadUrl)) . Topic::widget(['topics' => $data->topics]) .
                    Html::tag('div', '#' . $data->id . '&nbsp;opened ' . Yii::$app->formatter->asDatetime($data->create_time), ['class' => 'text-muted']);
                return $state.Html::tag('div', $t, ['class' => 'table-list-cell table-list-title']);
            }

        ],
        [
            'attribute' => 'responsible_id',
            'format' => 'html',
//            'filterInputOptions' => ['id' => 'responsible_id'],
            'value' => function ($data) {
                return Html::a($data['responsible'], ['/client/client/view', 'id' => $data->responsible_id]);
            },
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute' => 'responsible_id',
                'model' => $model,
                'formElementSelector' => 'td',
                'inputOptions' => [
                    'id' => 'responsible_id',
                ]
            ]),
        ],
        [
            'attribute' => 'recipient_id',
            'format' => 'html',
            'label' => Yii::t('app', 'Recipient'),
            'value' => function ($data) {
                return Html::a($data->recipient, ['/client/client/view', 'id' => $data->recipient_id]);

            },
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute' => 'recipient_id',
                'model' => $model,
                'formElementSelector' => 'td',
                'inputOptions' => [
                    'id' => 'recipient_id',
                ]
            ]),
        ],
        [
            'attribute' => 'author_id',
            'value' => function ($data) {
                return (
                $data->author_email ? Gravatar::widget([
                    'emailHash' => $data->author_email,
                    'defaultImage' => 'identicon',
                    'options' => [
                        'alt' => '',
                        'class' => 'img-circle',
                    ],
                    'size' => 16,
                ]) : '')
                . '&nbsp;&nbsp;'
                . Html::a($data->author, ['/client/client/view', 'id' => $data->author_id]);
            },
            'format' => 'html',
            'label' => Yii::t('app', 'Author'),
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute' => 'author_id',
                'model' => $model,
                'formElementSelector' => 'td',
                'inputOptions' => [
                    'id' => 'author_id',
                ]
            ]),
        ],
        [
            'attribute' => 'answer_count',
            'label' => Yii::t('app', 'Answers'),
            'format' => 'raw',
            'filter' => false,
            'value' => function ($data) {
                return Html::tag('span', '', ['class' => 'glyphicon glyphicon-comment text-muted']) . '&nbsp;&nbsp;' . $data->answer_count;
            },
            'contentOptions' => [
                'style' => 'font-size: larger;'
            ]
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{view}',
            'header' => Yii::t('app', 'Actions'),
            'buttons' => [
                //                'view' => function ($url, $model, $key) {
                //                    return GridActionButton::widget([
                //                        'url' => $url,
                //                        'icon' => '<i class="fa fa-eye"></i>',
                //                        'label' => Yii::t('app', 'Details'),
                //                    ]);
                //                },
                'state' => function ($url, $model, $key) {
                    if ($model->state == 'opened') {
                        //                        $title = Yii::t('app', 'Close');
                        //                        return Html::a('<i class="fa fa-times"></i>&nbsp;&nbsp;'.$title,
                        //                            ['close', 'id' => $model->id],
                        //                            ['title' => $title, 'class' => 'btn btn-default btn-xs', 'data-pjax' => 0]
                        //                        );
                        return Html::a('Close', ['close', 'id' => $model->id]);
                        //                        GridActionButton::widget([
                        //                            'url' => ['close', 'id' => $model->id],
                        //                            'icon' => '<i class="fa fa-times"></i>',
                        //                            'label' => Yii::t('app', 'Close'),
                        //                        ]);
                    }
                },
            ],
        ],
        'checkbox',
    ],
]); ?>
<?php $box->endBody(); ?>
<?php $box->endHeader(); ?>
<?php $box::end(); ?>
