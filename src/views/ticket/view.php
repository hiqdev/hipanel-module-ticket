<?php

use yii\helpers\StringHelper;

/**
 * @var yii\web\View
 * @var object $model
 */
$decorator = new \hipanel\modules\ticket\widgets\ThreadDecorator($model);

$this->title = '#' . $model->id;
$this->params['subtitle'] = StringHelper::truncateWords($decorator->subject, 7);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:ticket', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;

$action = 'answer';
$model->scenario = $action;

?>

<?= $this->render('_view', compact('action', 'model', 'client', 'topic_data', 'state_data', 'priority_data', 'decorator')) ?>
