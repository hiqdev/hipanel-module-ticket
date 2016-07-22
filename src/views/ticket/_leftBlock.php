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

FlagIconCssAsset::register($this);

/**
 * @var Thread
 */
$form = ConditionalFormWidget::begin([
    'form' => isset($form) ? $form : null,
    'options' => [
        'id' => 'left-block-comment-form',
        'action'  => $action,
        'options' => ['enctype' => 'multipart/form-data'],
    ],
]);

?>
<div class="row page-ticket">
    <div class="col-md-12">
        <?= Html::a(Yii::t('hipanel/ticket', 'Back to index'),
            ['index'],
            ['class' => 'btn btn-primary btn-block', 'style' => $model->isNewRecord ? 'margin-bottom: 20px;' : 'margin-bottom: 5px;']) ?>
        <?= \hipanel\widgets\ReminderButton::widget(['object_id' => $model->id]) ?>
        <?php if (!$model->isNewRecord) : ?>
            <?php
            $openTicketText = Yii::t('hipanel/ticket', 'Open ticket');
            $closeTicketText = Yii::t('hipanel/ticket', 'Close ticket');
            Pjax::begin(array_merge(Yii::$app->params['pjax'], [
                'id' => 'stateTicketButton',
                'enablePushState' => false,
                'clientOptions'   => [
                    'type' => 'POST',
                    'data' => [
                        "{$model->formName()}[id]" => $model->id,
                    ],
                ],
            ])) ?>
            <?php if ($model->state == Thread::STATE_CLOSE) : ?>
                <?= Html::a($openTicketText, ['open'], HtmlHelper::loadingButtonOptions(['class' => 'btn btn-block margin-bottom btn-warning'])) ?>
            <?php else : ?>
                <?= Html::a($closeTicketText, ['close'], HtmlHelper::loadingButtonOptions(['class' => 'btn btn-block margin-bottom btn-danger'])) ?>
            <?php endif ?>
            <?php Pjax::end() ?>
        <?php endif ?>


        <?php $box = Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
        ]) ?>

            <?= $this->render('_advancedForm', compact('form', 'model', 'topic_data', 'state_data', 'priority_data')) ?>

            <?php /*
            <?php if ($model->priority == 'medium') : ?>
                <?= Html::a('<span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;'.Yii::t('hipanel/ticket', 'Increase'), ['priority-up', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
            <?php else : ?>
                <?= Html::a('<span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;'.Yii::t('hipanel/ticket', 'Lower'), ['priority-down', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
            <?php endif ?>
            */ ?>
            <?php /*
            <?php if ($model->state=='opened') : ?>
                <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('hipanel/ticket', 'Close'), ['close', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-block',
                    'data' => [
                        'confirm' => Yii::t('hipanel/ticket', 'Are you sure you want to close this ticket?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php else : ?>
                <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('hipanel/ticket', 'Open'), ['open', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-block',
                    'data' => [
                        'confirm' => Yii::t('hipanel/ticket', 'Are you sure you want to open this ticket?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif ?>
            */ ?>

            <?php $box->beginFooter() ?>
                <?php if (!$model->isNewRecord) : ?>
                    <?= $this->render('_subscribeButton', compact('model')) ?>
                <?php endif ?>
            <?php $box->endFooter() ?>

        <?php $box->end() ?>
    </div>

<?php if ($client) : ?>
    <div class="col-md-12">
        <?php $box = Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
        ]) ?>
        <div class="profile-block">
            <div class="profile-photo">
                <?php if ($client->email) : ?>
                    <?= $this->render('//layouts/gravatar', ['email' => $client->email, 'size' => 120]) ?>
                <?php endif ?>
            </div>
            <div class="profile-user-name">
                <?= ClientSellerLink::widget([
                    'model' => $client,
                    'clientAttribute' => 'login',
                    'clientIdAttribute' => 'id',
                ]) ?>
            </div>
            <div class="profile-user-role"><?= Yii::t('hipanel/client', $client->type) ?></div>
        </div>
        <?php $box->beginFooter() ?>
        <div class="table-responsive">
            <?= ClientGridView::detailView([
                'model'   => $client,
                'boxed'   => false,
                'columns' => $client->login == 'anonym' ? ['name', 'email'] : [
                    'name', 'email', 'country',
                    'state', 'balance', 'credit',
                    'servers_spoiler', 'domains_spoiler', 'hosting',
                ],
            ]) ?>
        </div>
        <!-- /.table-responsive -->
        <?php if ($client->login != 'anonym') : ?>
            <?= Html::a('<i class="fa fa-info-circle" style="font-size:120%"></i>&nbsp;&nbsp;' . Yii::t('hipanel/ticket', 'Client details'), ['@client/view', 'id' => $client->id], ['class' => 'btn  btn-default btn-block']) ?>
        <?php endif ?>
        <?php $box->endFooter() ?>
        <?php $box->end() ?>
    </div>
<?php endif ?>
</div>

<?php ConditionalFormWidget::end() ?>
