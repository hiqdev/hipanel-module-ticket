<?php

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\ticket\models\Thread $model
 * @var integer $answer_id
 */

$answer = $model->getAnswer($answer_id);

$answer->scenario = 'update';

echo $this->render('_form', ['action' => ['@ticket/answer/update'], 'model' => $answer]);
