<?php

use hipanel\assets\OcticonsAsset;
use hipanel\modules\ticket\models\Answer;
use hipanel\modules\ticket\widgets\ConditionalFormWidget;
use hiqdev\assets\autosize\AutosizeAsset;
use hiqdev\assets\icheck\iCheckAsset;
use hipanel\widgets\TimePicker;
use hipanel\widgets\FileInput;
use yii\helpers\Html;

OcticonsAsset::register($this);
iCheckAsset::register($this);
AutosizeAsset::register($this);
$emptyPreviewText = \yii\helpers\Json::encode(Yii::t('hipanel/ticket', 'Nothing to preview'));
$this->registerJs(<<< JS
// Init iCheck
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
});
// Fetch preview
$(".js-get-preview").on('click', function (event) {
    event.preventDefault();
    var form = $(this).closest('form');
    var message = form.find('.message-text').val();
    $.post('preview', {text: message}, function (data) {
        form.find('.preview-container').html( data || $emptyPreviewText);
    });
});
JS
, \yii\web\View::POS_READY);

$this->registerCss(<<< CSS
.checkbox label {
    padding-left: 0
}
.checkbox div {
    margin-right: 5px;
}
.hidden-form-inputs { display: none; }
CSS
);

/**
 * @var Answer|\hipanel\modules\ticket\models\Thread
 */
$form = ConditionalFormWidget::begin([
    'form' => isset($form) ? $form : null,
    'options' => [
        'id' => 'leave-comment-form',
        'action'  => $action,
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'leave-comment-form',
        ],
    ],
]);

$this->registerJs("
// Expand message textarea
$('#{$form->getId()} textarea').one('focus', function(event) {
    $(this).closest('form').find('.hidden-form-inputs').toggle();
    $(this).attr('rows', '5');
    autosize(this);
});
");

if ($model->isNewRecord) {
    $this->registerJs("$('#{$form->getId()} textarea').trigger('focus');");
    echo $form->field($model, 'subject');
} else {
    echo Html::activeHiddenInput($model, 'id');

    if ($model->isAttributeActive('answer_id')) {
        echo Html::activeHiddenInput($model, 'answer_id');
    }
} ?>

<div class="comment-tab-wrapper">
    <div role="tabpanel" class="comment-tab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs hidden-form-inputs margin-bottom" role="tablist">
            <div class="pull-right" style="padding-top:0.5em">
                <?= Html::a(
                    '<span class="octicon octicon-markdown"></span> ' .
                    Yii::t('hipanel/ticket', 'Markdown is supported'),
                    'https://guides.github.com/features/mastering-markdown/',
                    ['target' => '_blank', 'class' => '', 'style' => 'border-bottom: 1px solid; border-bottom-style: dashed;']
                ) ?>
            </div>
            <li role="presentation" class="active">
                <a href="#message-<?= $form->getId() ?>" aria-controls="home" role="tab" data-toggle="tab" style="font-weight:bold"><?= Yii::t('hipanel/ticket', 'Message') ?></a>
            </li>
            <li role="presentation">
                <a href="#preview-<?= $form->getId() ?>" aria-controls="profile" role="tab" data-toggle="tab" class="js-get-preview">
                    <?= Yii::t('hipanel/ticket', 'Preview') ?>
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active message-tab" id="message-<?= $form->getId() ?>">
                <?= $form->field($model, 'message')->textarea([
                    'rows' => 1,
                    'placeholder' => Yii::t('hipanel/ticket', 'Compose your message here'),
                    'class' => ['form-control message-text'],
                ])->label(false); ?>

            </div>
            <div role="tabpanel" class="tab-pane preview-tab" id="preview-<?= $form->getId() ?>">
                <div class="well well-sm preview-container">
                    <?= Yii::t('hipanel/ticket', 'Nothing to preview') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden-form-inputs">
        <div class="row">
            <?php if ($model->isAttributeActive('file')) : ?>
                <div class="col-md-12">
                    <?= $form->field($model, 'file[]')->widget(FileInput::class, [
                        'options' => [
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'previewFileType'          => 'any',
                            'showRemove'               => true,
                            'showUpload'               => false,
                            'initialPreviewShowDelete' => true,
                            'maxFileCount'             => 5,
                            'msgFilesTooMany'          => 'Number of files selected for upload ({n}) exceeds maximum allowed limit of {m}. Please retry your upload!',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <?= Html::submitButton(Yii::t('hipanel', 'Submit'), ['class' => 'btn btn-success']); ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $is = $model instanceof Answer;
                        if (Yii::$app->user->can('support')) : ?>
                            <div class="pull-right">
                                <?= $form->field($model, 'spent')->widget(TimePicker::class, [
                                    'options' => [
                                        'value' => $model instanceof Answer
                                            ? (new DateTime('@' . (int) $model->spent * 60))->format('H:i')
                                            : '00:00',
                                    ],
                                    'pluginOptions' => [
                                        'showSeconds' => false,
                                        'showMeridian' => false,
                                        'minuteStep' => 1,
                                        'hourStep' => 1,
                                        'defaultTime' => '00:00',
                                    ],
                                ])->label(false); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <div class="pull-right">
                            <?php if (!$model->isNewRecord && $model->isAttributeActive('is_private')) : ?>
                                <?= $form->field($model, 'is_private')->checkbox(['class' => 'icheck']) ?>
                            <?php endif; ?>
                        </div>
                        <!-- /.pull-right -->
                    </div>
                </div>
            </div>
            <!-- /.col-md-12 -->
            <!-- /.row -->
        </div>
        <!-- /.row -->
    </div>
</div>

<?php ConditionalFormWidget::end() ?>
