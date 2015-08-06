<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

?>

<?php $form = ActiveForm::begin([
    'action'  => $action,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'leave-comment-form'],
]) ?>
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_leftBlock',  compact('form', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>
        </div>
        <div class="col-md-9">
            <?= $this->render('_rightBlock', compact('form', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>
        </div>
    </div>
<?php $form::end() ?>
