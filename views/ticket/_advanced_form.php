<?php
/**
 * @link    http://hiqdev.com/hipanel
 * @license http://hiqdev.com/hipanel/license
 * @copyright Copyright (c) 2015 HiQDev
 */
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\combo\StaticCombo;
use yii\helpers\Url;
use yii\web\JsExpression;

?>
    <!-- Topics -->
<?php if ($model->isNewRecord)
    $model->topics = 'general';
else
    $model->topics = implode(',', array_keys($model->topics));
print $form->field($model, 'topics')->widget(StaticCombo::className(), [
    'pluginOptions' => [
        'select2Options' => [
            'multiple' => true,
        ]
    ],
    'data' => $topic_data
]); ?>
<div class="row">
    <div class="col-md-6">
        <!-- State -->
        <?php
        if ($model->isNewRecord)
            $model->state = 'opened';
        print $form->field($model, 'state')->widget(StaticCombo::classname(), [
            'data' => $state_data,
        ]); ?>
    </div>
    <div class="col-md-6">
        <!-- Priority -->
        <?php
        if ($model->isNewRecord)
            $model->priority = 'medium';
        print $form->field($model, 'priority')->widget(StaticCombo::classname(), [
                'data' => $priority_data,
        ]); ?>
    </div>
</div>

    <!-- Responsible -->
<?= $form->field($model, 'responsible_id')->widget(ClientCombo::classname(), [
    'clientType' => 'manager'
]); ?>

<?php if ($model->scenario == 'insert') : ?>
    <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
        'clientType' => 'manager',
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>
<?php else : ?>
    <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
//        'clientType' => 'manager',
        'inputOptions' => [
            'value' => implode(',', array_keys($model->watchers)),
        ],
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]); ?>
<?php endif; ?>

<?php
if ($model->isNewRecord)
    $model->recipient_id = \Yii::$app->user->identity->id;
print $form->field($model, 'recipient_id')->widget(ClientCombo::classname()); ?>

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