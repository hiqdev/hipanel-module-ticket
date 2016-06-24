<?php

use yii\helpers\StringHelper;

/* @var $this yii\web\View */

$this->title = $model->threadViewTitle;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = StringHelper::truncateWords($model->threadViewTitle, 5);

$action = 'answer';
$model->scenario = $action;

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>

