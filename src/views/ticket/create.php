<?php

/* @var $this yii\web\View */
/* @var $model frontend\modules\ticket\models\Thread */

$this->title                   = Yii::t('app', 'Create ticket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$action = 'create';

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>
