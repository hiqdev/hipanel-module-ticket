<?php

use hipanel\modules\ticket\models\Thread;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Gravatar;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\client\models\Client $client
 */

$answerId = 'answer-' . $answer->answer_id;
$separator = '&nbsp;·&nbsp;';

?>

<?= Html::beginTag('div', ['class' => 'comment' . ($answer->is_answer ? ' answer' : ''), 'id' => $answerId]) ?>
    <?= Gravatar::widget([
        'email' => $answer->email_hash,
        'options' => [
            'alt' => $answer->author,
            'class' => 'comment-avatar',
        ],
        'size' => 32,
    ]) ?>
    <?= Html::beginTag('div', ['class' => 'comment-body']) ?>
        <?= Html::beginTag('div', ['class' => 'comment-text ' . ($answer->is_private ? 'ticket-answer-bg-grey' : '')]) ?>
            <div class="comment-heading">
                <?= ClientSellerLink::widget(['model' => $answer]) ?>
                <?php if ($answer->account) : ?>
                    <?= $separator ?> <b><?= $answer->account ?></b>
                <?php endif ?>
                <?= $separator ?> <?= Html::tag('span', Yii::$app->formatter->asDatetime($answer->create_time)) ?>
                <?php if (Yii::$app->user->can('client.read-ip') && $answer->ip) : ?>
                    <?= $separator ?> <?= Html::tag('span', 'IP: ' . $answer->ip) ?>
                    <?php $country_name = Yii::$app->geoip->lookupCountryName($answer->ip); ?>
                    <?php if ($country_name) : ?>
                        <?= $separator ?> <?= Html::tag('span', Yii::t('hipanel:ticket', 'Country') . ': ' . $country_name) ?>
                    <?php endif ?>
                <?php endif ?>
                <?= $separator ?>
                <?= Html::a("<i class='fa fa-hashtag'></i>", ['@ticket/view', 'id' => $model->id, '#' => $answerId], ['class' => 'name']) ?>
                <?php if ($answer->spent) : ?>
                    <?= Html::tag('span', Yii::t('hipanel:ticket', 'Time spent: {n}', ['n' => Yii::$app->formatter->asDuration($answer->spent * 60)]), ['class' => 'spent-time pull-right label label-info']) ?>
                <?php endif ?>
                <?= $separator ?>
                <?= Html::a(Yii::t('hipanel:ticket', 'Quote'), '#', ['class' => 'link-button comment-quote-button', 'data-answer-id' => $answer->answer_id]) ?>
                <?php if ((string) $answer->author_id === (string) Yii::$app->user->id) : ?>
                    <?= $separator ?>
                    <?= Html::a(Yii::t('hipanel:ticket', 'Edit'), '#update-answer-modal', [
                        'class' => 'link-button comment-edit-button',
                        'data' => [
                            'toggle' => 'modal',
                            'thread-id' => $answer->id,
                            'answer-id' => $answer->answer_id,
                        ],
                    ]) ?>
                <?php endif ?>
            </div>
            <div class="clearfix"></div>

            <?= Html::tag('span', Thread::parseMessage($answer->message), ['class' => 'body']) ?>

            <?php if (!empty($answer->files)) : ?>
                <?= $this->render('_attachments', ['model' => $answer]) ?>
            <?php endif ?>

        <?= Html::endTag('div') ?>

    <?= Html::endTag('div') ?>
<?= Html::endTag('div') ?>
