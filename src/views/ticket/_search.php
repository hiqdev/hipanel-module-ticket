<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\AdvancedSearch;
use hiqdev\yii2\daterangepicker\DateRangePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View
 * @var AdvancedSearch $search
 * @var array $state_data
 * @var array $priority_data
 * @var array $topic_data
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('anytext_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('message') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('numbers') ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('author_id')->widget(ClientCombo::class); ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('recipient_id')->widget(ClientCombo::class, [
            'clientType' => 'client',
        ]) ?>
    </div>
<?php endif; ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::label(Yii::t('hipanel', 'Date')) ?>
        <?= DateRangePicker::widget([
            'model' => $search->model,
            'attribute' => 'time_from',
            'attribute2' => 'time_till',
            'options' => [
                'class' => 'form-control',
            ],
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $state_data,
        'hasId' => true,
        'multiple' => false,
    ]) ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('responsible')->widget(ClientCombo::class, [
            'clientType' => ['manager', 'admin', 'owner', 'reseller'],
            'multiple' => true,
        ]); ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('executor')->widget(ClientCombo::class, [
            'clientType' => ['manager', 'admin', 'owner', 'reseller'],
            'multiple' => true,
        ]); ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('priority')->widget(StaticCombo::class, [
            'data' => $priority_data,
            'hasId' => true,
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?php echo $search->field('watcher_ids')->widget(ClientCombo::class, [
            'clientType' => ['manager', 'admin', 'owner'],
            'hasId' => true,
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ],
            ],
        ]) ?>
    </div>
<?php endif; ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('topics')->widget(StaticCombo::class, [
        'data' => $topic_data,
        'hasId' => true,
        'multiple' => true,
    ]); ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('hide_payment')->checkbox(['class' => 'option-input']) ?>
</div>
