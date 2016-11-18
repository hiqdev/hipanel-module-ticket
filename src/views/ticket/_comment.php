<?php

use hipanel\modules\ticket\models\Thread;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use yii\helpers\Html;

/* @var \hipanel\modules\client\models\Client $client */

$answerId = 'answer-' . $answer->answer_id;
echo Html::beginTag('div', ['class' => ($answer->is_answer) ? 'comment answer' : 'comment', 'id' => $answerId]);

echo Gravatar::widget([
    'email' => $answer->email_hash,
    'options' => [
        'alt' => $answer->author,
        'class' => 'comment-avatar',
    ],
    'size' => 32,
]);

echo Html::beginTag('div', ['class' => 'comment-body']);
echo Html::beginTag('div', ['class' => 'comment-text']) ?>
<div class="comment-heading" xmlns="http://www.w3.org/1999/html">
    <?= ClientSellerLink::widget([
        'model' => new \yii\base\DynamicModel([
            'client_id' => $answer->author_id,
            'client' => $answer->author,
            'seller_id' => $answer->seller_id,
            'seller' => $answer->author_seller,
        ]),
        'clientAttribute' => 'client',
        'clientIdAttribute' => 'client_id',
        'sellerAttribute' => 'seller',
        'sellerIdAttribute' => 'seller_id',
    ]) ?>
    &nbsp;·&nbsp;
    <?= Html::tag('span', Yii::$app->formatter->asDatetime($answer->create_time)) ?>
    <?= $answer->ip ? "&nbsp;·&nbsp;" . Html::tag('span', 'IP: ' . $answer->ip) : '' ?>
    <?= $answer->ip ? "&nbsp;·&nbsp;" . Html::tag('span', Yii::t('hipanel:ticket', 'Country') . ': ' . Yii::$app->geoip->ip($answer->ip)->country) : '' ?>
    &nbsp;·&nbsp;
    <?= Html::a("<i class='fa fa-hashtag'></i>", ['@ticket/view', 'id' => $model->id, '#' => $answerId], ['class' => 'name']) ?>
    <?php if ($answer->spent) : ?>
        <?= Html::tag('span', Yii::t('hipanel:ticket', 'Time spent: {n}', ['n' => Yii::$app->formatter->asDuration($answer->spent * 60)]), ['class' => 'spent-time pull-right label label-info']) ?>
    <?php endif ?>
</div>
<div class="clearfix"></div>

<?= Html::tag('span', Thread::parseMessage($answer->message), ['class' => 'body']) ?>

<?php if (!empty($answer->files)) {
    echo $this->render('_attachments', ['model' => $answer]);
} ?>

<?= Html::endTag('div') ?>

<?= Html::beginTag('div', ['class' => 'comment-footer']) ?>
<button class="link-button comment-quote-button"
        data-answer-id="<?= $answer_id ?>"><?= Yii::t('hipanel:ticket', 'Quote') ?></button>
<?php if ((string)$answer->author_id === (string)Yii::$app->user->id) : ?>
    &nbsp;&nbsp;·&nbsp;&nbsp;
    <?= Html::a(Yii::t('hipanel:ticket', 'Edit'), '#update-answer-modal', [
        'class' => 'link-button comment-edit-button',
        'data' => [
            'toggle' => 'modal',
            'thread-id' => $answer->id,
            'answer-id' => $answer->answer_id,
        ],
    ]) ?>
<?php endif ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
