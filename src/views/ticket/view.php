<?php

use hiqdev\yii2\reminder\widgets\ReminderButton;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View
 */
$reminder = ReminderButton::widget([
    'object_id' => $model->id,
]);

$this->title                    = '#' . $model->id;
$this->params['subtitle']       = StringHelper::truncateWords($model->subject, 7) . '&nbsp;' . $reminder;
$this->params['breadcrumbs'][]  = ['label' => Yii::t('hipanel:ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][]  = '#' . $model->id;

$action = 'answer';
$model->scenario = $action;

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>
