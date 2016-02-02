<?php

use hipanel\frontend\assets\OcticonsAsset;
use hiqdev\assets\autosize\AutosizeAsset;
use hiqdev\assets\icheck\iCheckAsset;
use kartik\widgets\TimePicker;
use yii\helpers\Html;

OcticonsAsset::register($this);
iCheckAsset::register($this);
AutosizeAsset::register($this);
$translate = Yii::t('app', 'Nothing to preview');
$dopScript = <<< JS
// Init iCheck
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
});
// Expand message textarea
$('.leave-comment-form textarea').one('focus', function(event) {
    $('.hidden-form-inputs').toggle();
    $(this).attr('rows', '5');
    autosize(this);
});
// Fetch preview
$(".js-get-preview").on('click', function (event) {
    event.preventDefault();
    var message = $('#thread-message').val();
    $.post("preview", {text: message}, function( data ) {
        $('#preview .preview-container').html( data || '$translate');
    });
});
JS;
$this->registerJs($dopScript, \yii\web\View::POS_READY);
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
if ($model->isNewRecord) {
    $this->registerJs("$('.leave-comment-form textarea').trigger('focus');");
}


?>

<?php if ($model->isNewRecord) { ?>
    <?= $form->field($model, 'subject') ?>
<?php } else { ?>
    <?= Html::activeHiddenInput($model, 'id') ?>
<?php } ?>

<div role="tabpanel" class="comment-tab">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs hidden-form-inputs margin-bottom" role="tablist">
        <div class="pull-right" style="padding-top:0.5em">

            <?= Html::a(
                '<span class="octicon octicon-markdown"></span> ' .
                Yii::t('app', 'Markdown supported'),
                'https://guides.github.com/features/mastering-markdown/',
                ['target' => '_blank', 'class' => '', 'style' => 'border-bottom: 1px solid; border-bottom-style: dashed;']
            ) ?>
        </div>
        <li role="presentation" class="active">
            <a href="#message" aria-controls="home" role="tab" data-toggle="tab" style="font-weight:bold"><?= Yii::t('app', 'Message') ?></a>
        </li>
        <li role="presentation">
            <a href="#preview" aria-controls="profile" role="tab" data-toggle="tab" class="js-get-preview"><?= Yii::t('app', 'Preview') ?></a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="message">
            <?= $form->field($model, 'message')->textarea(['rows' => 1, 'placeholder' => Yii::t('app', 'Write a message here')])->label(false); ?>

        </div>
        <div role="tabpanel" class="tab-pane" id="preview">
            <div class="well well-sm preview-container">
                <?= Yii::t('app', 'Nothing to preview') ?>
            </div>
        </div>
    </div>
</div>
<div class="hidden-form-inputs">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'file[]')->widget(\kartik\widgets\FileInput::className(), [
                'options' => [
//                    'accept' => 'image/*',
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
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2">
                    <?php // print '&nbsp;' . Html::submitButton(Yii::t('app', 'Submit and close'), ['class' => 'btn btn-default margin-bottom', 'name' => 'submit_close']); ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']); ?>
                </div>
                <div class="col-md-3">
                    <?php if (Yii::$app->user->can('support')) : ?>
                        <div class="pull-right">
                            <?= $form->field($model, $model->isNewRecord ? 'spent' : 'answer_spent')->widget(TimePicker::className(), [
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
                        <?php if (!$model->isNewRecord) : ?>
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
