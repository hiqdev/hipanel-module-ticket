<?php

use hipanel\widgets\Box;
use hipanel\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('hipanel/ticket', 'Ticket Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(Yii::$app->params['pjax']); ?>
    <?php Box::begin() ?>
        <p><?= Yii::t('app', 'This section allows you to manage the settings on mail alerts'); ?></p>
        <?php $form = ActiveForm::begin([
            'options' => ['data-pjax' => '1'],
        ]); ?>

        <?= $form->field($model, 'ticket_emails')->hint(Yii::t('app', 'In this field you can specify to receive email notifications of ticket. By default, the notification is used for editing the main e-mail')); ?>
        <?= $form->field($model, 'send_message_text')->checkbox()->hint(Yii::t('app', 'When checked, mail notification includes the text of the new message. By default, the mail has only the acknowledgment of the response and a link to the ticket. Be careful, the text can include confidential information.')); ?>
        <?= $form->field($model, 'new_messages_first')->checkbox()->hint(Yii::t('app', 'When checked, new answers in the ticket will be displayed first.')); ?>

        <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
        <?php $form->end(); ?>
    <?php Box::end() ?>
<?php Pjax::end() ?>
