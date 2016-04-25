<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;

/* @var $model hipanel\modules\ticket\models\Thread */

$this->title                   = Yii::t('hipanel/ticket', 'Create ticket');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$action = 'create';

?>

<?php $form = ActiveForm::begin([
    'id' => 'create-thread-form',
    'action'  => $action,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'create-thread-form'],
]) ?>

<?= $this->render('_view', compact('form', 'action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>

<?php $form->end();
