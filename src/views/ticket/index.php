<?php

use hipanel\modules\ticket\grid\TicketGridView;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title                   = Yii::t('hipanel:ticket', 'Tickets');
$this->params['subtitle']      = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<'CSS'
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
    padding: 2px 5px;
    line-height: .9;
}
CSS
);
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?php $page->setSearchFormData(compact(['state_data', 'topic_data', 'priority_data'])) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel:ticket', 'Create ticket'), ['@ticket/create'], ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => Yii::$app->user->can('support') ?  [
                'create_time', 'lastanswer', 'spent',
                'subject', 'responsible_id', 'recipient', 'author', 'author_seller',
            ] : ['subject'],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?php if (Yii::$app->user->can('support')) : ?>
            <?= $page->renderBulkButton('subscribe', Yii::t('hipanel:ticket', 'Subscribe')) ?>
            <?= $page->renderBulkButton('unsubscribe', Yii::t('hipanel:ticket', 'Unsubscribe')) ?>
        <?php endif ?>
        <?= $page->renderBulkButton('close', Yii::t('hipanel:ticket', 'Close'), [
            'color' => 'danger',
            'confirm' => Yii::t('hipanel:ticket', 'Are you sure you want to close these tickets?')
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true, 'id' => 'ticket-grid-pjax'])) ?>
                <?= TicketGridView::widget([
                    'boxed' => false,
                    'id'           => 'ticket-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel'  => $model,
                    'rowOptions'   => function ($model, $key, $index, $grid) {
                        return ['class' => ($model['priority'] === 'high') ? 'bg-danger' : ''];
                    },
                    'enableListChecker' => true,
                    'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
                ]); ?>
            <?php Pjax::end() ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
