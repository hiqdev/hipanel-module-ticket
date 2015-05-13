<?php
/**
 * @link    http://hiqdev.com/hipanel
 * @license http://hiqdev.com/hipanel/license
 * @copyright Copyright (c) 2015 HiQDev
 */
use hipanel\widgets\Combo2;
use hipanel\widgets\DefaultCombo2;
use yii\helpers\Url;
use yii\web\JsExpression;

?>
    <!-- Topics -->
<?php if ($model->isNewRecord)
    $model->topics = 'general';
else
    $model->topics = array_keys($model->topics);
print $form->field($model, 'topics')->widget(Combo2::classname(), [
    'type' => DefaultCombo2::className(),
    'fieldOptions' => [
        'pluginOptions' => [
            'allowClear' => true,
            'data' => array_merge(["" => ""], $topic_data),
        ],
    ]
]); ?>
<div class="row">
    <div class="col-md-6">
        <!-- State -->
        <?php
        if ($model->isNewRecord)
            $model->state = 'opened';
        print $form->field($model, 'state')->widget(Combo2::classname(), [
            'type' => DefaultCombo2::className(),
            'fieldOptions' => [
                'pluginOptions' => [
                    'data' => array_merge(["" => ""], $state_data),
                ]
            ]
        ]); ?>
    </div>
    <div class="col-md-6">
        <!-- Priority -->
        <?php
        if ($model->isNewRecord)
            $model->priority = 'medium';
        print $form->field($model, 'priority')->widget(Combo2::classname(), [
            'type' => DefaultCombo2::className(),
            'fieldOptions' => [
                'pluginOptions' => [
                    'data' => array_merge(["" => ""], $priority_data),
                    'allowClear' => true,
                ]
            ]
        ]); ?>
    </div>
</div>

    <!-- Responsible -->
<?= $form->field($model, 'responsible_id')->widget(Combo2::classname(), [
    'type' => \hipanel\modules\client\assets\combo2\Manager::className()
]); ?>

<?php if ($model->scenario == 'insert') : ?>
    <?= $form->field($model, 'watchers')->widget(Combo2::classname(), [
        'type' => \hipanel\modules\client\assets\combo2\Manager::className()
    ]); ?>
<?php endif; ?>

<?php
if ($model->isNewRecord)
    $model->recipient_id = \Yii::$app->user->identity->id;
print $form->field($model, 'recipient_id')->widget(Combo2::classname(), ['type' => \hipanel\modules\client\assets\combo2\Client::className()]); ?>

<?php if ($model->scenario != 'answer') : ?>
    <?= $form->field($model, 'spent')->widget(kartik\widgets\TimePicker::className(), [
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 1,
            'hourStep' => 1,
            'defaultTime' => '00:00',
        ]
    ]); ?>
<?php else : ?>
    <?= $form->field($model, 'answer_spent')->widget(kartik\widgets\TimePicker::className(), [
        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 1,
            'hourStep' => 1,
            'defaultTime' => '00:00',
        ]
    ])->label(Yii::t('app', 'Spen time')); ?>
<?php endif; ?>