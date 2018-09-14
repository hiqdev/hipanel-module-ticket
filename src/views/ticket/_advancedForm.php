<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\ticket\models\Thread;
use hiqdev\combo\StaticCombo;
use hiqdev\xeditable\widgets\ComboXEditable;
use hiqdev\xeditable\widgets\XEditable;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/**
 * @var Thread $model
 */

$isSupport = Yii::$app->user->can('support');
$isNewRecord = $model->isNewRecord;

if ($isNewRecord) {
    if ($isSupport) {
        $model->priority = 'medium';
        $model->responsible = Yii::$app->user->identity->login;
    }
    $model->recipient_id = Yii::$app->user->identity->id;
    $this->registerCss("
    .table.detail-view { table-layout: fixed; }
    .table.detail-view th { width: 30%; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
    .table.detail-view td { width: 70%; }
    ");
}
$this->registerCss(".table.detail-view { margin-bottom: 0px; }");
?>

<?php $form = ActiveForm::begin([
    'action' => $action,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'leave-comment-form'],
]) ?>
<div class="table-responsive">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => array_filter([
            !$isNewRecord ? [
                'attribute' => 'state',
                'value' => $model->state === Thread::STATE_CLOSE ? Yii::t('hipanel:ticket', 'Closed') : Yii::t('hipanel:ticket', 'Opened'),
            ] : null,
            [
                'attribute' => 'topics',
                'format' => 'raw',
                'value' => $isNewRecord ? $form->field($model, 'topics')->widget(StaticCombo::class, [
                    'hasId' => true,
                    'data' => $topic_data,
                    'multiple' => true,
                ])->label(false) : XEditable::widget([
                    'model' => $model,
                    'attribute' => 'topics',
                    'pluginOptions' => [
                        'disabled' => !$isSupport,
                        'type' => 'checklist',
                        'source' => $model->xFormater($topic_data),
                        'placement' => 'bottom',
                        'emptytext' => Yii::t('hipanel:ticket', 'Empty'),
                    ],
                ]),
            ],
            $isSupport ? [
                'attribute' => 'priority',
                'format' => 'raw',
                'value' => $isNewRecord ? $form->field($model, 'priority')->widget(StaticCombo::class, [
                    'data' => $priority_data,
                    'hasId' => true,
                ])->label(false) : XEditable::widget([
                    'model' => $model,
                    'attribute' => 'priority',
                    'pluginOptions' => [
                        'disabled' => !$isSupport,
                        'type' => 'select',
                        'source' => $priority_data,
                    ],
                ]),
            ] : null,
            $isSupport ? [
                'attribute' => 'responsible',
                'format' => 'raw',
                'value' => $isNewRecord ? $form->field($model, 'responsible')->widget(ClientCombo::class, [
                    'clientType' => $model->getResponsibleClientTypes(),
                ])->label(false) : ComboXEditable::widget([
                    'model' => $model,
                    'attribute' => 'responsible',
                    'combo' => [
                        'class' => ClientCombo::class,
                        'clientType' => $model->getResponsibleClientTypes(),
                        'inputOptions' => [
                            'class' => 'hidden',
                        ],
                        'pluginOptions' => [
                            'select2Options' => [
                                'width' => '20rem',
                            ],
                        ],
                    ],
                    'pluginOptions' => [
                        'placement' => 'bottom',
                    ],
                ]),
            ] : null,
            $isSupport && !$isNewRecord ? [
                'attribute' => 'spent',
                'value' => Yii::$app->formatter->asDuration($model->spent * 60),
            ] : null,
            $isSupport && $isNewRecord ? [
                'attribute' => 'watchers',
                'format' => 'raw',
                'value' => $form->field($model, 'watchers')->widget(ClientCombo::class, [
                    'clientType' => $model->getResponsibleClientTypes(),
                    'pluginOptions' => [
                        'select2Options' => [
                            'multiple' => true,
                        ],
                    ],
                ])->label(false),
            ] : null,
            $isNewRecord && $isSupport ? [
                'attribute' => 'recipient_id',
                'format' => 'raw',
                'value' => $form->field($model, 'recipient_id')->widget(ClientCombo::class)->label(false),
            ] : null,
        ]),
    ]) ?>
</div>
<?php $form->end() ?>
