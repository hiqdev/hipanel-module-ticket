<?php

use hipanel\modules\ticket\grid\TicketGridView;
use hipanel\widgets\ActionBox;

$this->title                   = Yii::t('hipanel/ticket', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');

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

#ticket-grid td.answer .label {
    text-align: center;
    font-size: 9px;
    padding: 2px 3px;
    line-height: .9;
}
CSS
);
?>

<?php $box = ActionBox::begin(compact('model', 'dataProvider')) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('hipanel/ticket', 'Create ticket')) ?>
        <?= $box->renderSearchButton() ?>
        <?= $box->renderSorter([
            'attributes' => [
                'create_time', 'lastanswer', 'spent',
                'subject', 'responsible_id', 'recipient', 'author', 'author_seller',
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
    <?php $box->endActions(); ?>
    <?php $box->renderBulkActions([
        'items' => [
            $box->renderBulkButton(Yii::t('hipanel/ticket', 'Subscribe'), 'subscribe'),
            $box->renderBulkButton(Yii::t('hipanel/ticket', 'Unsubscribe'), 'unsubscribe'),
            $box->renderBulkButton(Yii::t('hipanel/ticket', 'Close'), 'close', 'danger'),
        ],
    ]) ?>
    <?= $box->renderSearchForm(compact('topic_data', 'state_data', 'priority_data')) ?>
<?php $box->end() ?>

<?php $box->beginBulkForm() ?>
    <?= TicketGridView::widget([
        'id'           => 'ticket-grid',
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['class' => ($model['priority'] === 'high') ? 'bg-danger' : ''];
        },
        'columns' => [
            'checkbox',
            'subject',
            'author_id',
            'responsible_id',
            'recipient_id',
            'answer_count',
            'actions',
        ],
    ]); ?>
<?php $box->endBulkForm() ?>
