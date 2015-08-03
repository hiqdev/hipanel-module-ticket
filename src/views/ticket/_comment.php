<?php

use cebe\gravatar\Gravatar;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\ticket\models\Thread;
use yii\helpers\Html;

$this->registerJs(<<< JS
// Reply button
$('.comment-reply-button').on('click', function(event) {
    event.preventDefault();
    scrollTo('.leave-comment-form');
    $('#thread-message').focus();
});
// Quote button
$(".comment-qute-button").on("click", function(event) {
    event.preventDefault();
    var ta = document.querySelector('textarea');
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
        scrollTo('.leave-comment-form');
        $('.comment-tab a[href="#message"').tab('show'); // Open tab
        chatInput.focus(); // Scroll to form
        chatInput.val(data);

        // Dispatch a 'autosize:update' event to trigger a resize:
        var evt = document.createEvent('Event');
        evt.initEvent('autosize:update', true, false);
        ta.dispatchEvent(evt);
    });
});
JS
, \yii\web\View::POS_READY);
?>
<?= Html::beginTag('div', ['class' => ($answer['is_answer']) ? 'comment answer' : 'comment', 'id' => 'answer-' . $answer['answer_id']]); ?>
    <!-- Avatar -->
<?php if (isset($answer['email']) && filter_var($answer['email'], FILTER_VALIDATE_EMAIL)) : ?>
    <?= Gravatar::widget([
        'email'        => $answer['email'],
        'defaultImage' => 'identicon',
        'options'      => [
            'alt'   => $answer['author'],
            'class' => 'comment-avatar',
        ],
        'size' => 32,
    ]); ?>
<?php endif; ?>

<?= Html::beginTag('div', ['class' => 'comment-body']); ?>
<?= Html::beginTag('div', ['class' => 'comment-text']); ?>
    <div class="comment-heading" xmlns="http://www.w3.org/1999/html">
        <?= Html::a($answer['author'], [
            '/client/client/view',
            'id' => $answer['author_id'],
        ], ['class' => 'name']); ?><?= Html::tag('span', Yii::$app->formatter->asDatetime($answer['create_time'])) ?>
    </div>

<?= Html::tag('span', Thread::parseMessage($answer['message']), ['class' => 'body']); ?>

<?php if (ArrayHelper::getValue($answer, 'files') !== null) : ?>
    <?= $this->render('_attachment', ['attachment' => $answer['files'], 'object_id' => $model->id, 'object_name' => 'thread', 'answer_id' => $answer_id]); ?>
<?php endif; ?>

<?= Html::endTag('div'); ?>

<?= Html::beginTag('div', ['class' => 'comment-footer']); ?>
    <button class="link-button comment-reply-button"><?= Yii::t('app', 'Reply'); ?></button>
    &nbsp;&nbsp;·&nbsp;&nbsp;
    <button class="link-button comment-qute-button" data-answer-id="<?= $answer_id; ?>"><?= Yii::t('app', 'Qute'); ?></button>
<?= Html::endTag('div'); ?>

<?= Html::endTag('div'); ?>

<?= Html::endTag('div'); ?>
