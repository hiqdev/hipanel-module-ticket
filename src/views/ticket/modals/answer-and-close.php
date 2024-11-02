<?php

use hipanel\modules\ticket\models\Thread;
use hipanel\widgets\BulkOperation;

/** @var Thread[] $models */
/** @var Thread $model */

?>

<?= BulkOperation::widget([
    'model' => $model,
    'models' => $models,
    'formatterField' => 'subject',
    'scenario' => 'answer-and-close',
    'affectedObjects' => Yii::t('hipanel:ticket', 'Affected tickets'),
    'hiddenInputs' => ['id'],
    'visibleInputs' => ['message'],
    'submitButton' => Yii::t('hipanel:ticket', 'Send message and close tickets'),
    'submitButtonOptions' => ['class' => 'btn btn-danger'],
]) ?>
