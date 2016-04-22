<?php

use hipanel\helpers\Url;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\Box;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 */

$this->registerJs(<<<JS
$('.message-block-move-btn').on('click', function () {
    var button = $(this);
    var comments_form = $('.leave-comment-form');
    var comment_tab_sibling = comments_form.prev();

    button.after(comments_form);
    comment_tab_sibling.after(button);
    comments_form.find('textarea').focus().trigger('focus');
});
JS
    , View::POS_READY);

?>

<!-- Chat box -->
<?php $box = Box::begin([
    'options' => [
        'class' => 'box-primary',
    ],
]) ?>

    <div><!-- dummy div to make .message-block-move-btn work. do not remove --></div>
    <?= $this->render('_form', compact('form', 'model', 'topic_data', 'state_data', 'priority_data', 'action')) ?>
    <?php if ($model->isRelationPopulated('answers')) : ?>
        <hr class="no-panel-padding-h panel-wide padding-bottom">
        <div class="widget-article-comments tab-pane panel no-padding no-border fade in active">
            <?php foreach ($model->answers as $answer_id => $answer) : ?>
                <?php if (!empty($answer->message)) : ?>
                    <?= $this->render('_comment', ['model' => $model, 'answer_id' => $answer_id, 'answer' => $answer]) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php if ($model->isRelationPopulated('answers')) : ?>
            <hr class="no-panel-padding-h panel-wide padding-bottom md-mb-0">
            <?= Html::button(Yii::t('hipanel/ticket', 'Answer'), ['class' => 'message-block-move-btn btn btn-default']); ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $actionUrl = Json::encode(Url::to(['update-answer-modal']));
    echo AjaxModal::widget([
        'id' => 'update-answer-modal',
        'header' => Html::tag('h4', Yii::t('hipanel/ticket', 'Message editing'), ['class' => 'modal-title']),
        'scenario' => 'update-answer',
        'actionUrl' => ['update-answer-modal'],
        'size' => Modal::SIZE_LARGE,
        'toggleButton' => false,
        'clientEvents' => [
            'show.bs.modal' => new JsExpression("function(e) {
                var button = e.relatedTarget;
                var id = $(button).attr('data-thread-id');
                var answer_id = $(button).attr('data-answer-id');
                $.ajax({
                    url: $actionUrl,
                    data: {id: id, answer_id: answer_id},
                    success: function (data) {
                        $('#update-answer-modal .modal-body').html(data);
                    }
                });
            }")
        ]
    ]) ?>

<?php $box->end() ?><!-- /.box (chat box) -->
