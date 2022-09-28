<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\ticket\grid\StatisticGridView;
use hipanel\modules\ticket\grid\StatisticRepresentations;
use hipanel\modules\ticket\models\StatisticSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var StatisticSearch $model
 * @var IndexPageUiOptions $uiModel
 * @var StatisticRepresentations $representationCollection
 * @var ActiveDataProvider $dataProvider
 * @var array $state_data
 * @var array $topic_data
 * @var array $priority_data
 */

$this->title                   = Yii::t('hipanel:ticket', 'Tickets statistics');
$this->params['subtitle']      = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

<?php $page->setSearchFormData(['state_data' => $state_data, 'topic_data' => $topic_data, 'priority_data' => $priority_data]) ?>

<?php $page->beginContent('main-actions') ?>
    <?= Html::a(Yii::t('hipanel:ticket', 'Create ticket'), ['@ticket/create'], ['class' => 'btn btn-sm btn-success']) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('sorter-actions') ?>
    <?= $page->renderSorter([
        'attributes' => [
            'client',
            'spent',
        ],
    ]) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('representation-actions') ?>
    <?= $page->renderRepresentations($representationCollection) ?>
<?php $page->endContent() ?>

<?php $page->beginContent('table') ?>
    <?php $page->beginBulkForm() ?>
        <?= StatisticGridView::widget([
            'boxed' => false,
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
        ]) ?>
    <?php $page->endBulkForm() ?>
<?php $page->endContent() ?>

<?php $page->end() ?>
