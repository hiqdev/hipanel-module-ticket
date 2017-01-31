<?php

use hipanel\helpers\HtmlHelper;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\ticket\models\Thread;
use hipanel\modules\ticket\widgets\ConditionalFormWidget;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\Pjax;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

/**
 * @var \yii\web\View
 * @var Thread $model
 * @var string $action
 */
FlagIconCssAsset::register($this);

$form = ConditionalFormWidget::begin([
    'form' => isset($form) ? $form : null,
    'options' => [
        'id' => 'left-block-comment-form',
        'action' => $action,
        'options' => ['enctype' => 'multipart/form-data'],
    ],
]);

?>
<div class="row page-ticket">
    <div class="col-md-12">
        <?= Html::a(Yii::t('hipanel:ticket', 'Back to index'),
            ['index'],
            ['class' => 'btn btn-primary btn-block btn-sm', 'style' => $model->isNewRecord ? 'margin-bottom: 20px;' : 'margin-bottom: 5px;']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <?php $openTicketText = Yii::t('hipanel:ticket', 'Open ticket'); ?>
            <?php $closeTicketText = Yii::t('hipanel:ticket', 'Close ticket'); ?>
            <?php Pjax::begin(array_merge(Yii::$app->params['pjax'], [
                'id' => 'stateTicketButton',
                'enablePushState' => false,
                'clientOptions' => [
                    'type' => 'POST',
                    'data' => [
                        "{$model->formName()}[id]" => $model->id,
                    ],
                ],
            ])) ?>
            <?php if ($model->state === Thread::STATE_CLOSE) : ?>
                <?= Html::a($openTicketText, ['open'], HtmlHelper::loadingButtonOptions(['class' => 'btn btn-block btn-sm margin-bottom btn-warning'])) ?>
            <?php else : ?>
                <?= Html::a($closeTicketText, ['close'], HtmlHelper::loadingButtonOptions(['class' => 'btn btn-block btn-sm margin-bottom btn-danger'])) ?>
            <?php endif ?>
            <?php Pjax::end() ?>
        <?php endif ?>

        <?php $box = Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
        ]) ?>

        <?= $this->render('_advancedForm', compact('form', 'model', 'topic_data', 'state_data', 'priority_data')) ?>

        <?php $box->beginFooter() ?>
        <?php if (!$model->isNewRecord) : ?>
            <?= $this->render('_subscribeButton', compact('model')) ?>
        <?php endif ?>
        <?php $box->endFooter() ?>

        <?php $box->end() ?>
    </div>

    <?php if ($client && Yii::$app->user->can('support') && Yii::$app->user->id !== $model->recipient_id) : ?>
        <div class="col-md-12">
            <?php $box = Box::begin([
                'options' => [
                    'class' => 'box-solid',
                ],
            ]) ?>
            <div class="profile-block">
                <div class="profile-photo">
                    <?php if ($client->email) : ?>
                        <?= $this->render('//layouts/gravatar', ['email' => $client->email, 'size' => 120, 'alt' => '']) ?>
                    <?php endif ?>
                </div>
                <div class="profile-user-name">
                    <?= ClientSellerLink::widget(['model' => $client]) ?>
                </div>
                <div class="profile-user-role"><?= Yii::t('hipanel:client', $client->type) ?></div>
            </div>
            <?php $box->beginFooter() ?>
            <div class="table-responsive">
                <?= ClientGridView::detailView([
                    'model' => $client,
                    'boxed' => false,
                    'columns' => $client->login === 'anonym' ? ['name', 'email'] : [
                        'name', 'email', 'messengers', 'country',
                        'state', 'balance', 'credit',
                        'servers_spoiler', 'domains_spoiler', 'hosting',
                    ],
                ]) ?>
            </div>
            <?php if ($client->login !== 'anonym') : ?>
                <?= Html::a('<i class="fa fa-info-circle" style="font-size:120%"></i>&nbsp;&nbsp;' . Yii::t('hipanel:ticket', 'Client details'), ['@client/view', 'id' => $client->id], ['class' => 'btn  btn-default btn-sm btn-block']) ?>
            <?php endif ?>
            <?php $box->endFooter() ?>
            <?php $box->end() ?>
        </div>
    <?php endif ?>
</div>

<?php ConditionalFormWidget::end() ?>
