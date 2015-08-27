<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\Gravatar;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

?>
<!-- Topics -->
<?php if ($model->isNewRecord) {
    $model->topics = 'general';
} else {
    $model->topics = implode(',', array_keys($model->topics));
}
print $form->field($model, 'topics')->widget(StaticCombo::className(), [
    'hasId' => true,
    'pluginOptions' => [
        'select2Options' => [
            'multiple' => true,
        ],
    ],
    'data' => $topic_data,
]); ?>
<div class="row">
    <div class="col-md-6">
        <!-- State -->
        <?php if ($model->isNewRecord) {
            $model->state = 'opened';
        } ?>
        <?= $form->field($model, 'state')->widget(StaticCombo::classname(), [
            'data' => $state_data,
            'hasId' => true,
        ]) ?>
    </div>
    <div class="col-md-6">
        <!-- Priority -->
        <?php if ($model->isNewRecord) {
            $model->priority = 'medium';
        } ?>
        <?= $form->field($model, 'priority')->widget(StaticCombo::classname(), [
            'data' => $priority_data,
            'hasId' => true,
        ]) ?>
    </div>
</div>
<?php if (Yii::$app->user->can('support')) : ?>
    <?php if ($model->isNewRecord) : ?>
        <!-- Responsible -->
        <?= $form->field($model, 'responsible_id')->widget(ClientCombo::classname(), [
                'clientType' => ['manager', 'admin', 'owner'],
        ]); ?>
        <?php else : ?>
        <div class="row ">
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    <?= $model->getAttributeLabel('responsible') ?>:&nbsp;
                </label>
                <div class="col-sm-8">
                    <span class="form-control-static">
                        <?= Gravatar::widget([
                            'emailHash'    => $model->responsible_email,
                            'defaultImage' => 'identicon',
                            'size' => 14,
                        ]); ?>
                        <?= Html::a($model->responsible, ['client/client/view', 'id' => $model->responsible_id]); ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->scenario === 'insert') : ?>
        <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
            'clientType' => ['manager', 'admin', 'owner'],
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ],
            ],
        ]); ?>
    <?php else : ?>
        <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
            'clientType' => ['manager', 'admin', 'owner'],
            'hasId' => true,
            'inputOptions' => [
                'value' => $model->watchers ? implode(',', array_keys($model->watchers)) : null,
            ],
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ],
            ],
        ]); ?>
    <?php endif; ?>

    <?php if ($model->isNewRecord) {
        $model->recipient_id = \Yii::$app->user->identity->id;
    } ?>
    <?= $form->field($model, 'recipient_id')->widget(ClientCombo::classname()) ?>

    <?php if ($model->scenario !== 'answer') : ?>
        <?= $form->field($model, 'spent')->widget(kartik\widgets\TimePicker::className(), [
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
                'hourStep' => 1,
                'defaultTime' => '00:00',
            ],
        ]); ?>
    <?php else : ?>
        <?= $form->field($model, 'answer_spent')->widget(kartik\widgets\TimePicker::className(), [
            'pluginOptions' => [
                'showSeconds' => false,
                'showMeridian' => false,
                'minuteStep' => 1,
                'hourStep' => 1,
                'defaultTime' => '00:00',
            ],
        ])->label(Yii::t('app', 'Spen time')); ?>
    <?php endif; ?>
<?php endif; ?>