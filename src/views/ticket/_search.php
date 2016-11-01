<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\DatePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

/**
 * @var \hipanel\widgets\AdvancedSearch
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('anytext_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('author_id')->widget(ClientCombo::class); ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('recipient_id')->widget(ClientCombo::class, [
        'clientType' => 'client',
    ]) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::label(Yii::t('hipanel', 'Date'))?>
        <?= DatePicker::widget([
            'model' => $search->model,
            'attribute' => 'time_from',
            'attribute2' => 'time_till',
            'type' => DatePicker::TYPE_RANGE,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
            ],
        ]) ?>
    </div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $state_data,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ],
        ],
    ]) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('responsible_id')->widget(ClientCombo::class, [
        'clientType' => 'manager',
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('topics')->widget(StaticCombo::class, [
        'data' => $topic_data,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('priority')->widget(StaticCombo::class, [
        'data' => $priority_data,
        'hasId' => true,
    ]) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?php echo $search->field('watchers')->widget(ClientCombo::class, [
        'clientType' => ['manager', 'admin', 'owner'],
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]) ?>
</div>
