<?php

use hipanel\grid\ActionColumn;
use hipanel\grid\GridView;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\widgets\Topic;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use yii\bootstrap\Button;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = Yii::t('app', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle']      = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

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
}
CSS
);
?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('app', 'Create ticket')) ?>
        &nbsp;
        <?= $box->renderSearchButton() ?>
        &nbsp;
        <?= $box->renderSorter([
            'attributes' => [
                'create_time', 'lastanswer', 'spent', 'answer_count',
                'subject', 'responsible_id', 'recipient', 'author', 'author_seller',
            ],
        ]) ?>
    <?php $box->endActions(); ?>
    <?php $box->renderBulkActions([
        'items' => [
            $box->renderBulkButton(Yii::t('app', 'Subscribe'), 'subscribe'),
            $box->renderBulkButton(Yii::t('app', 'Unsubscribe'), 'unsubscribe'),
            $box->renderBulkButton(Yii::t('app', 'Close'), 'close', 'danger'),
        ],
    ]) ?>
    <?= $box->renderSearchForm() ?>
<?php $box::end() ?>

<?php $box = Box::begin(['renderBody' => false, 'options' => ['class' => 'box-primary']]); ?>
<?php $box->beginBody(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'id'           => 'ticket-grid',
    'striped'      => false,
    'rowOptions'   => function ($model, $key, $index, $grid) {
        return ['class' => ($model['priority'] === 'high') ? 'bg-danger' : ''];
    },
    'columns' => [
        'checkbox',
        [
            'attribute' => 'subject',
            'format'    => 'raw',
            'value'     => function ($data) {
                $ava = Html::tag('div', Gravatar::widget([
                    'emailHash'    => $data->author_email,
                    'defaultImage' => 'identicon',
                    'options'      => [
                        'alt'   => '',
                        'class' => 'img-circle',
                    ],
                    'size' => 40,
                ]), ['class' => 'pull-right']);
                $state = $data->state === 'opened'
                    ? Html::tag('div', '<span class="fa fa-circle-o text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type'])
                    : Html::tag('div', '<span class="fa fa-check-circle text-muted"></span>', ['class' => 'table-list-cell table-list-cell-type'])
                ;
                $t = Html::tag('b', Html::a($data->subject, $data->threadUrl)) . Topic::widget(['topics' => $data->topics]) .
                    Html::tag('div', '#' . $data->id . '&nbsp;opened ' . Yii::$app->formatter->asDatetime($data->create_time), ['class' => 'text-muted']);

                return $ava . $state . Html::tag('div', $t, ['class' => 'table-list-cell table-list-title']);
            },

        ],
        [
            'attribute' => 'author_id',
            'value'     => function ($model) {
                return ClientSellerLink::widget(compact('model'));
            },
            'format' => 'html',
            'label'  => Yii::t('app', 'Author'),
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute'           => 'author_id',
                'model'               => $model,
                'formElementSelector' => 'td',
                'inputOptions'        => [
                    'id' => 'author_id',
                ],
            ]),
        ],
        [
            'attribute' => 'responsible_id',
            'format'    => 'html',
//            'filterInputOptions' => ['id' => 'responsible_id'],
            'value' => function ($data) {
                return Html::a($data['responsible'], ['/client/client/view', 'id' => $data->responsible_id]);
            },
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute'           => 'responsible_id',
                'model'               => $model,
                'formElementSelector' => 'td',
                'inputOptions'        => [
                    'id' => 'responsible_id',
                ],
            ]),
        ],
        [
            'attribute' => 'recipient_id',
            'format'    => 'html',
            'label'     => Yii::t('app', 'Recipient'),
            'value'     => function ($data) {
                return Html::a($data->recipient, ['/client/client/view', 'id' => $data->recipient_id]);

            },
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute'           => 'recipient_id',
                'model'               => $model,
                'formElementSelector' => 'td',
                'inputOptions'        => [
                    'id' => 'recipient_id',
                ],
            ]),
        ],
        [
            'attribute' => 'answer_count',
            'label'     => Yii::t('app', 'Answers'),
            'format'    => 'raw',
            'filter'    => false,
            'value'     => function ($data) {
                return Html::tag('span', '', ['class' => 'glyphicon glyphicon-comment text-muted']) . '&nbsp;&nbsp;' . $data->answer_count;
            },
            'contentOptions' => [
                'style' => 'font-size: larger;',
            ],
        ],
        [
            'class'    => ActionColumn::className(),
            'template' => '{view}',
            'header'   => Yii::t('app', 'Actions'),
            'buttons'  => [
                //                'view' => function ($url, $model, $key) {
                //                    return GridActionButton::widget([
                //                        'url' => $url,
                //                        'icon' => '<i class="fa fa-eye"></i>',
                //                        'label' => Yii::t('app', 'Details'),
                //                    ]);
                //                },
                'state' => function ($url, $model, $key) {
                    if ($model->state === 'opened') {
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
    ],
]); ?>
<?php $box->endBody(); ?>
<?php $box->endHeader(); ?>
<?php $box::end(); ?>
