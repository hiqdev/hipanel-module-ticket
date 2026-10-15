<?php

use hipanel\modules\client\models\Client;
use hipanel\modules\ticket\forms\TicketExportSearch;
use hipanel\widgets\TagsInput;
use hiqdev\combo\StaticCombo;
use hiqdev\yii2\daterangepicker\DateRangePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var TicketExportSearch $model
 * @var array $topic_data
 */

$this->title = Yii::t('hipanel:ticket', 'Export with threads');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// The download doesn't reload the page, so there is no "done" event to wait for:
// the button is only held for a few seconds to prevent double submits.
$this->registerJs(<<<'JS'
    $('#tickets-export-form').on('beforeSubmit', function () {
        const button = $(this).find('button[type=submit]').button('loading');
        setTimeout(() => button.button('reset'), 5000);
    });
JS
);
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => 'tickets-export-form']) ?>

                <?= $form->field($model, 'time_from', ['validateOnBlur' => false, 'validateOnChange' => false])->widget(DateRangePicker::class, [
                    'attribute2' => 'time_till',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]) ?>

                <?= $form->field($model, 'status')->inline()->radioList($model->statusOptions()) ?>

                <?= $form->field($model, 'topics')->widget(StaticCombo::class, [
                    'data' => $topic_data,
                    'hasId' => true,
                    'multiple' => true,
                ]) ?>

                <?php if (Yii::$app->user->can('owner-staff')) : ?>
                    <?= $form->field($model, 'client_tags')->widget(TagsInput::class, ['searchModel' => new Client()]) ?>
                <?php endif ?>

                <div class="callout callout-warning">
                    <?= Yii::t('hipanel:ticket', 'The file contains full message threads, including internal notes. Do not share it outside the team.') ?>
                </div>

                <p class="text-muted">
                    <?= Yii::t('hipanel:ticket', 'Format: JSON, one object per ticket with its metadata, first response time, change history and messages. Clients are shown as "client".') ?>
                </p>

                <?= Html::submitButton('<i class="fa fa-download"></i> ' . Yii::t('hipanel:ticket', 'Download'), [
                    'class' => 'btn btn-success',
                    'data-loading-text' => '<i class="fa fa-refresh fa-spin"></i> ' . Yii::t('hipanel:ticket', 'Preparing file...'),
                ]) ?>

                <?php ActiveForm::end() ?>
                <?php
                // The picker fills its inputs without firing change events, so validating on blur
                // reports "Period cannot be blank" before a range is picked, and the error stays.
                // Re-validate once the range is applied or cleared instead. Registered after the
                // form so it runs after the widget's own handler has set the values.
                $periodInputId = Html::getInputId($model, 'time_from');
                $this->registerJs(<<<JS
                    $('#$periodInputId').on('apply.daterangepicker cancel.daterangepicker', function () {
                        $('#tickets-export-form').yiiActiveForm('validateAttribute', '$periodInputId');
                    });
                JS);
                ?>
            </div>
        </div>
    </div>
</div>
