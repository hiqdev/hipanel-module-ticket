<?php

use Yii;
use yii\helpers\Html;
use hipanel\widgets\Pjax;

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => false]));

if (array_key_exists(Yii::$app->user->identity->id, $model->watchers)) {
    echo Html::a('<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;' . Yii::t('app', 'Unsubscribe'), ['unsubscribe', 'id' => $model->id], ['class' => 'btn  btn-default btn-block', 'data' => ['pjax' => '1']]);
} else {
    echo Html::a('<i class="fa fa-eye"></i>&nbsp;&nbsp;' . Yii::t('app', 'Subscribe'), ['subscribe', 'id' => $model->id], ['class' => 'btn  btn-default btn-block', 'data' => ['pjax' => '1']]);
}

Pjax::end();
