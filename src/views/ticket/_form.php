<?php

use hiqdev\assets\autosize\AutosizeAsset;
use hiqdev\assets\icheck\iCheckAsset;
use yii\helpers\Html;

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
//    autosize(this);
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
                'Markdown supported',
                'https://guides.github.com/features/mastering-markdown/',
                ['target' => '_blank', 'class' => 'label label-default markdown-supported']
            ) ?>
        </div>
        <li role="presentation" class="active">
            <a href="#message" aria-controls="home" role="tab" data-toggle="tab" style="font-weight:bold">Message</a>
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
                <div class="col-md-1">
                    <?php // print '&nbsp;' . Html::submitButton(Yii::t('app', 'Submit and close'), ['class' => 'btn btn-default margin-bottom', 'name' => 'submit_close']); ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']); ?>
                </div>
                <div class="col-md-7">
                    <?php if (!$model->isNewRecord) : ?>
                    <div class="pull-right">
                        <?= $form->field($model, 'answer_spent')->widget(kartik\widgets\TimePicker::className(), [
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
                <div class="col-md-4">
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
