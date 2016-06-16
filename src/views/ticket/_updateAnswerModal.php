<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @var \yii\web\View
 * @var \hipanel\modules\ticket\models\Thread $model
 * @var integer $answer_id
 */
use hipanel\modules\ticket\widgets\ConditionalFormWidget;

$answer = $model->getAnswer($answer_id);
$action = ['@ticket/answer/update'];

$answer->scenario = 'update';
$form = ConditionalFormWidget::begin([
    'form' => isset($form) ? $form : null,
    'options' => [
        'id' => 'update-comment-form',
        'action'  => $action,
        'options' => ['enctype' => 'multipart/form-data', 'class' => 'leave-comment-form'],
    ],
]);
echo $this->render('_form', ['form' => $form, 'action' => $action, 'model' => $answer]);
$this->registerJs("$('#{$form->getId()} textarea').trigger('focus')");
ConditionalFormWidget::end();
