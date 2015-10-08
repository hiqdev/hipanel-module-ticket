<?php
use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;
use kartik\widgets\DatePicker;
use yii\helpers\Html;

?>

<div class="col-md-4">
    <?= $search->field('subject') ?>

    <?= $search->field('time_from')->widget(DatePicker::className(), [
        'model' => $search->model,
        'attribute' => 'time_from',
        'attribute2' => 'time_till',
//        'separator' => Yii::t('app', '&larr; between &rarr;'),
        'type' => DatePicker::TYPE_RANGE,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ],
    ])->label(Yii::t('app', 'Date')) ?>
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $state_data,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ],
        ],
    ]) ?>
</div>

<div class="col-md-4">
    <?= $search->field('author_id')->widget(ClientCombo::classname()); ?>

    <?= $search->field('responsible_id')->widget(ClientCombo::classname(), [
        'clientType' => 'manager',
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>

    <?= $search->field('topics')->widget(StaticCombo::classname(), [
        'data' => $topic_data,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>
</div>

<div class="col-md-4">
    <?= $search->field('recipient_id')->widget(ClientCombo::classname(), [
        'clientType' => 'client',
    ]) ?>

    <?= $search->field('priority')->widget(StaticCombo::classname(), [
        'data' => $priority_data,
        'hasId' => true,
    ]) ?>

    <?php echo $search->field('watchers')->widget(ClientCombo::classname(), [
        'clientType' => ['manager', 'admin', 'owner'],
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]) ?>
</div>
