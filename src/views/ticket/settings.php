<?php

use hipanel\widgets\Box;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Model $model
 */

$this->title = Yii::t('hipanel:ticket', 'Ticket Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Box::begin() ?>
    <p><?= Yii::t('hipanel:ticket', 'This section allows you to manage the settings on mail alerts') ?></p>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => '1'],
    ]) ?>

    <?= $form->field($model, 'ticket_emails')->hint(Yii::t('hipanel:ticket', 'In this field you can specify to receive email notifications of ticket. By default, the notification is used for editing the main e-mail')) ?>
    <?= $form->field($model, 'send_message_text')->checkbox()->hint(Yii::t('hipanel:ticket', 'When checked, mail notification includes the text of the new message. By default, the mail has only the acknowledgment of the response and a link to the ticket. Be careful, the text can include confidential information.')) ?>
    <?= $form->field($model, 'new_messages_first')->checkbox()->hint(Yii::t('hipanel:ticket', 'When checked, new answers in the ticket will be displayed first.')) ?>

    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    <?php $form->end() ?>
<?php Box::end() ?>
