<?php
use hipanel\modules\ticket\grid\TemplateGridView;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = Yii::t('hipanel/ticket', 'Answer templates');
$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel/ticket', 'Create template'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
        <?= IndexLayoutSwitcher::widget() ?>
        <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= TemplateGridView::widget([
                'dataProvider' => $dataProvider,
                'boxed' => false,
                'filterModel'  => $model,
                'columns'      => [
                    'checkbox',
                    'author_id',
                    'name',
                    'is_published',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
