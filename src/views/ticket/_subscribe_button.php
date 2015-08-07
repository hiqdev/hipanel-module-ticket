<?php

use yii\helpers\Html;
use hipanel\widgets\Pjax;
use yii\helpers\Url;
use yii\web\JsExpression;

Pjax::begin(array_merge(Yii::$app->params['pjax'], [
    'enablePushState' => false,
    'clientOptions'   => [
        'type' => 'POST',
        'data' => ["{$model->formName()}[id]" => $model->id],
    ],
]));

$subscribed = array_key_exists(Yii::$app->user->identity->id, $model->watchers);
if ($subscribed) {
    $action = ['unsubscribe', 'id' => $model->id];
    $label  = '<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;' . Yii::t('app', 'Unsubscribe');
} else {
    $action = ['subscribe', 'id' => $model->id];
    $label  = '<i class="fa fa-eye"></i>&nbsp;&nbsp;' . Yii::t('app', 'Subscribe');
}

echo Html::a($label, $action, ['class' => 'btn btn-default btn-block', 'onClick' => new JsExpression("$(this).button('loading');")]);
Pjax::end();
