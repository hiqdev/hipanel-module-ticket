<?php

use common\components\Lang;
use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\modules\ticket\grid\TicketGridView;
use hipanel\modules\ticket\widgets\Topic;
use hipanel\widgets\ActionBox;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use yii\helpers\Html;

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

<?php $box = ActionBox::begin(compact('model', 'dataProvider')) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('app', 'Create ticket')) ?>
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
            $box->renderBulkButton(Yii::t('app', 'Subscribe'), 'subscribe'),
            $box->renderBulkButton(Yii::t('app', 'Unsubscribe'), 'unsubscribe'),
            $box->renderBulkButton(Yii::t('app', 'Close'), 'close', 'danger'),
        ],
    ]) ?>
    <?= $box->renderSearchForm(compact('topic_data','state_data','priority_data')) ?>
<?php $box::end() ?>

<?php $box->beginBulkForm() ?>
    <?= TicketGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'id'           => 'ticket-grid',
        'striped'      => false,
        'hover'        => false,
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
<?php $box::endBulkForm() ?>
