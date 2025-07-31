<?php

use hipanel\helpers\Url;
use hipanel\modules\ticket\assets\ThreadCheckerAsset;
use hipanel\modules\ticket\widgets\ThreadDecorator;
use hipanel\widgets\AjaxModal;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var \hipanel\modules\ticket\models\Thread $model
 * @var ThreadDecorator $decorator
 */
ThreadCheckerAsset::register($this);

$threadCheckerOptions = Json::encode([
    'threadId' => $model->id,
    'lastAnswerId' => $model->getMaxAnswerId(),
    'ajax' => ['url' => Url::to('@ticket/get-new-answers')],
]);

$this->registerJs(<<<JS
function openCommentForm (event) {
  var button = $(event.currentTarget);
  var comments_form = $('.leave-comment-form');
  var comment_tab_sibling = comments_form.prev();

  button.after(comments_form);
  comment_tab_sibling.after(button);
  comments_form.find('textarea').focus().trigger('focus');
}

$('.widget-article-comments').threadChecker($threadCheckerOptions);

$('.message-block-move-btn').on('click', openCommentForm);

const messageElement = document.getElementById('thread-message');
if (typeof openCommentForm !== 'undefined' && messageElement && messageElement.value) {
  $('.message-block-move-btn').click();
}

$(".comment-quote-button").on("click", function(event) {
    event.preventDefault();
    var chatInput = $('#thread-message');
    var answer_id = $(this).data('answer-id');
    var overlay = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
    var formBox = chatInput.parents('.box');

    $.ajax({
        method: "POST",
        url: "get-quoted-answer",
        cache: false,
        data: {id: answer_id},
        beforeSend: function() {
            formBox.append(overlay);
        }
    }).done(function(data) {
        formBox.find('.overlay').remove(); // Remove ajax spiner
        scrollTo('.comment-tab');
        $('.comment-tab a[href="#message"').tab('show'); // Open tab
        chatInput.val(data).trigger('blur');
        chatInput.focus(); // Scroll to form
    });
});
JS
    , View::POS_LOAD);

?>

<div class="box box-widget">
    <?php if (!$model->isNewRecord) : ?>
        <div class="box-header with-border">
            <h3 class="box-title">
                <?php if (!$model->isOpen()) : ?>
                    <span class="label label-default" style="text-transform: uppercase"><?= Yii::t('hipanel:ticket', 'Closed') ?></span>&nbsp;
                <?php endif ?>
                <?= sprintf('<b>#%s</b> - %s', $model->id, $decorator->subject) ?>
            </h3>
        </div>
    <?php endif; ?>
    <div class="box-body">
        <div><!-- dummy div to make .message-block-move-btn work. do not remove --></div>
        <?= $this->render('_form', compact('form', 'model', 'topic_data', 'state_data', 'priority_data', 'action')) ?>
        <?php if ($model->isRelationPopulated('answers')) : ?>
            <hr class="no-panel-padding-h panel-wide padding-bottom">
            <div class="widget-article-comments tab-pane panel no-padding no-border">
                <?= $this->render('_answers', ['model' => $model, 'client' => $client]) ?>
            </div>
            <?php if ($model->isRelationPopulated('answers')) : ?>
                <hr class="no-panel-padding-h panel-wide padding-bottom md-mb-0">
                <?= Html::button(
                    $model->isOpen() ? Yii::t('hipanel:ticket', 'Answer') : Yii::t('hipanel:ticket', 'Answer in closed ticket'),
                    ['class' => 'message-block-move-btn btn btn-default']
                ); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php $actionUrl = Json::encode(Url::to(['update-answer-modal'])) ?>
        <?= AjaxModal::widget([
            'id' => 'update-answer-modal',
            'header' => Html::tag('h4', Yii::t('hipanel:ticket', 'Message editing'), ['class' => 'modal-title']),
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
            }"),
            ],
        ]) ?>
    </div>
</div>
