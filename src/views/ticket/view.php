<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title                   = $model->threadViewTitle;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = StringHelper::truncateWords($model->threadViewTitle, 5);

$this->registerCss('
    .text-message {
        margin: 1rem;
    }
');

$action = 'answer';

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data')) ?>

