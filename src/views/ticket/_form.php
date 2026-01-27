<?php

use hipanel\assets\OcticonsAsset;
use hipanel\modules\ticket\models\Answer;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\widgets\ConditionalFormWidget;
use hipanel\modules\ticket\widgets\TemplatesWidget;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;
use hipanel\widgets\FileInput;
use hipanel\widgets\TimePicker;
use hipanel\assets\CheckboxStyleAsset;
use hisite\modules\news\models\Article;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * @var array $priority_data
 * @var array $state_data
 * @var array $topic_data
 * @var string $action
 * @var View $this
 * @var Answer|Thread $model
 */

OcticonsAsset::register($this);
CheckboxStyleAsset::register($this);
$emptyPreviewText = Json::encode(Yii::t('hipanel:ticket', 'Nothing to preview'));
$this->registerJs(<<< JS
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
    , View::POS_READY);

$this->registerCss(<<< 'CSS'
.checkbox label {
    padding-left: 0
}
.checkbox div {
    margin-right: 5px;
}
.hidden-form-inputs { display: none; }
CSS
);
?>

<?php
$form = ConditionalFormWidget::begin([
    'form' => $form ?? null,
    'options' => [
        'id' => 'leave-comment-form',
        'action' => $action,
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
});
");
?>

<?php if ($model->isNewRecord) : ?>
    <?php $this->registerJs("$('#{$form->getId()} textarea').trigger('focus');"); ?>
    <?= $form->field($model, 'subject'); ?>
<?php else: ?>
    <?= Html::activeHiddenInput($model, 'id'); ?>

    <?php if ($model->isAttributeActive('answer_id')) : ?>
        <?= Html::activeHiddenInput($model, 'answer_id'); ?>
    <?php endif ?>
<?php endif ?>

<div class="comment-tab-wrapper">
    <div role="tabpanel" class="comment-tab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs hidden-form-inputs margin-bottom" role="tablist">
            <div class="pull-right" style="padding-top:0.5em">
                <?= Html::a(
                    '<span class="octicon octicon-markdown"></span> ' .
                    Yii::t('hipanel:ticket', 'Markdown is supported'),
                    'https://guides.github.com/features/mastering-markdown/',
                    [
                        'target' => '_blank',
                        'class' => '',
                        'style' => 'border-bottom: 1px solid; border-bottom-style: dashed;',
                        'tabindex' => '-1',
                    ]
                ) ?>
            </div>
            <li role="presentation" class="active">
                <a href="#message-<?= $form->getId() ?>" aria-controls="home" role="tab" data-toggle="tab" style="font-weight:bold" tabindex="-1">
                    <?= Yii::t('hipanel:ticket', 'Message') ?>
                </a>
            </li>
            <li role="presentation">
                <a href="#preview-<?= $form->getId() ?>" aria-controls="profile" role="tab" data-toggle="tab" class="js-get-preview" tabindex="-1">
                    <?= Yii::t('hipanel:ticket', 'Preview') ?>
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active message-tab" id="message-<?= $form->getId() ?>">
                <?= $form->field($model, 'message')->textarea([
                    'rows' => 1,
                    'placeholder' => Yii::t('hipanel:ticket', 'Compose your message here'),
                    'class' => ['form-control message-text'],
                ])->label(false); ?>

            </div>
            <div role="tabpanel" class="tab-pane preview-tab" id="preview-<?= $form->getId() ?>">
                <div class="well well-sm preview-container">
                    <?= Yii::t('hipanel:ticket', 'Nothing to preview') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden-form-inputs">
        <?php if (class_exists(Article::class)): ?>
            <div class="row">
                <?= TemplatesWidget::widget() ?>
            </div>
        <?php endif ?>
        <div class="row">
            <?php if ($model->isAttributeActive('file')) : ?>
                <div class="col-md-12">
                    <?= $form->field($model, 'file[]')->widget(FileInput::class, ['options' => ['multiple' => true]]) ?>
                </div>
            <?php endif; ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <?= Html::submitButton(
                            $model->isOpen()
                                ? Yii::t('hipanel:ticket', 'Answer')
                                : ($model->isNewRecord
                                    ? Yii::t('hipanel:ticket', 'Create ticket')
                                    : Yii::t('hipanel:ticket', 'Answer and open')),
                            ['class' => 'btn btn-success']
                        ); ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $is = $model instanceof Answer;
                        if (Yii::$app->user->can('ticket.set-time') && $model->canSetSpent() ) : ?>
                            <div class="pull-right">
                                <?= $form->field($model, 'spent')->widget(TimePicker::class, [
                                    'options' => [
                                        'value' => $model instanceof Answer
                                            ? (new DateTime('@' . (int) $model->spent * 60))->format('H:i')
                                            : '00:00',
                                    ],
                                    'clientOptions' => [
                                        'minuteIncrement' => 1,
                                    ],
                                ])->label(false); ?>
                                <?= $form->field($model, 'spent_billable')->checkbox(['class' => 'option-input', 'checked' => true]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <?php if (!$model->isNewRecord && $model->isAttributeActive('is_private') && Yii::$app->user->can('ticket.set-private')) : ?>
                                <?= $form->field($model, 'is_private')->checkbox(['class' => 'option-input']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <?php if (!$model->isNewRecord && Yii::$app->user->can('owner-staff')) : ?>
                                <?php $model->topics = empty($model->topics) ? ['technical'] : array_keys($model->topics) ?>
                                <?php $model->responsible ??= Yii::$app->user->getIdentity()->username ?>
                                <?= $form->field($model, 'responsible')->widget(ClientCombo::class, [
                                    'clientType' => $model->getResponsibleClientTypes(),
                                ]) ?>
                                <?= $form->field($model, 'topics')->widget(StaticCombo::class, [
                                    'hasId' => true,
                                    'data' => $topic_data ?? [],
                                    'multiple' => true,
                                ]) ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ConditionalFormWidget::end() ?>
