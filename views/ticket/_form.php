<?php

use hiqdev\assets\icheck\iCheckAsset;
use hiqdev\assets\autosize\AutosizeAsset;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;

iCheckAsset::register($this);
AutosizeAsset::register($this);

$dopScript = <<< JS
// Init iCheck
$('input.icheck').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
});
// Expand message textarea
$('.leave-comment-form textarea').one('focus', function(e) {
    $('.hidden-form-inputs').toggle();
    $(this).attr('rows', '5');
    autosize(this);
});
// Fetch preview
$(".js-get-preview").on('click', function (event) {
    event.preventDefault();
    var message = $('#thread-message').val();
    $.post("preview", {text: message}, function( data ) {
        $('#preview .preview-container').html( data || 'Nothing to preview');
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

.hidden-form-inputs {
    display: none;
}
CSS
); ?>

<?php if ($model->isNewRecord)
    print $form->field($model, 'subject'); ?>

<div role="tabpanel" class="comment-tab">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs hidden-form-inputs margin-bottom" role="tablist">
        <li role="presentation" class="active">
            <a href="#message" aria-controls="home" role="tab" data-toggle="tab">Message</a>
        </li>
        <li role="presentation">
            <a href="#preview" aria-controls="profile" role="tab" data-toggle="tab" class="js-get-preview">Preview</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="message">
            <?= $form->field($model, 'message')->textarea(['rows' => 1, 'placeholder' => 'Write a message here'])->label(false); ?>

        </div>
        <div role="tabpanel" class="tab-pane" id="preview">
            <div class="well well-sm preview-container">
                Nothing to preview
            </div>
        </div>
    </div>
</div>
<div class="hidden-form-inputs">
    <div class="row">
        <div class="col-md-12">
            <div class="text-right">
                <?= Html::a(
                    Html::img('/img/github_markdown-16.png') . '&nbsp;&nbsp;Markdown supported',
                    'https://guides.github.com/features/mastering-markdown/',
                    ['target' => '_blank', 'class' => 'label label-default']
                ); ?>
            </div>
            <?= $form->field($model, 'file[]')->widget(\kartik\widgets\FileInput::className(), [
                'options' => [
//                    'accept' => 'image/*',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'showRemove' => true,
                    'showUpload' => false,
                    'initialPreviewShowDelete' => true,
                    'maxFileCount' => 5,
                    'msgFilesTooMany' => 'Number of files selected for upload ({n}) exceeds maximum allowed limit of {m}. Please retry your upload!',
                ]
            ]); ?>
        </div>
        <div class="col-md-3">
            <?php if (!$model->isNewRecord)
                print $form->field($model, 'is_private')->checkbox(['class' => 'icheck']); ?>
        </div>
        <div class="col-md-9">
            <div class="pull-right">
                <?= Html::submitButton(Yii::t('app', 'Submit and close'), ['class' => 'btn btn-default margin-bottom', 'name' => 'submit_close']); ?>
                &nbsp;
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary margin-bottom']); ?>
            </div>
        </div>
    </div>
</div>
