<?php

use yii\helpers\StringHelper;

/* @var $this yii\web\View */

$this->title    = $model->subject;
$this->subtitle = '#' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;

$action = 'answer';
$model->scenario = $action;

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>

