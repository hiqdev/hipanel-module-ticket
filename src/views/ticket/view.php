<?php

use hipanel\widgets\ReminderButton;

/* @var $this yii\web\View */

$reminder = ReminderButton::widget([
    'object_id' => $model->id,
    'toggleButton' => [
        'label' => '<i class="fa fa-bell-o"></i>&nbsp;&nbsp;' . Yii::t('hipanel/reminder', 'Create reminder'),
        'class' => 'btn margin-bottom btn-info pull-right btn-xs'
    ]
]);


$this->title                    = $model->subject;
$this->params['subtitle']       = '#' . $model->id . '&nbsp;' . $reminder;
$this->params['breadcrumbs'][]  = ['label' => Yii::t('hipanel/ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][]  = '#' . $model->id;

$action = 'answer';
$model->scenario = $action;

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>
