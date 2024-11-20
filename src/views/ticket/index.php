<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\ticket\grid\TicketGridView;
use hipanel\modules\ticket\grid\TicketGridLegend;
use hipanel\modules\ticket\grid\TicketRepresentations;
use hipanel\modules\ticket\models\ThreadSearch;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ThreadSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var TicketRepresentations $representationCollection
 * @var IndexPageUiOptions $uiModel
 * @var array $state_data
 * @var array $topic_data
 * @var array $priority_data
 */

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

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

<?php $page->setSearchFormData(['state_data' => $state_data, 'topic_data' => $topic_data, 'priority_data' => $priority_data]) ?>

<?php $page->beginContent('main-actions') ?>
    <?= Html::a(Yii::t('hipanel:ticket', 'Create ticket'), ['@ticket/create'], ['class' => 'btn btn-sm btn-success']) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('legend') ?>
    <?= GridLegend::widget(['legendItem' => new TicketGridLegend($model)]) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('sorter-actions') ?>
    <?= $page->renderSorter([
        'attributes' => Yii::$app->user->can('access-subclients') ?  [
            'create_time', 'lastanswer', 'spent',
            'subject', 'responsible_id', 'recipient', 'author', 'author_seller',
        ] : ['subject'],
    ]) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('bulk-actions') ?>
    <?php if (Yii::$app->user->can('access-subclients')) : ?>
        <?= $page->renderBulkButton('subscribe', Yii::t('hipanel:ticket', 'Subscribe')) ?>
        <?= $page->renderBulkButton('unsubscribe', Yii::t('hipanel:ticket', 'Unsubscribe')) ?>
    <?php endif ?>
    <?= AjaxModal::widget([
        'id' => 'answer-and-close-modal',
        'bulkPage' => true,
        'header' => Html::tag('h4', Yii::t('hipanel:ticket', 'Answer and close'), ['class' => 'modal-title']),
        'scenario' => 'answer-and-close',
        'size' => Modal::SIZE_LARGE,
        'toggleButton' => ['label' => Yii::t('hipanel:ticket', 'Answer and close'), 'class' => 'btn btn-sm btn-danger'],
    ]) ?>
    <?= $page->renderBulkButton('close', Yii::t('hipanel:ticket', 'Close'), [
        'color' => 'danger',
        'confirm' => Yii::t('hipanel:ticket', 'Are you sure you want to close these tickets?')
    ]) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('table') ?>
    <?php $page->beginBulkForm() ?>
        <?= TicketGridView::widget([
            'boxed' => false,
            'id'           => 'ticket-grid',
            'tableOptions' => ['class' => 'table table-striped table-bordered table-condensed'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'rowOptions' => static function ($model) {
                return GridLegend::create(new TicketGridLegend($model))->gridRowOptions();
            },
            'enableListChecker' => true,
            'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
        ]); ?>
    <?php $page->endBulkForm() ?>
<?php $page->endContent() ?>
<?php $page->end() ?>
