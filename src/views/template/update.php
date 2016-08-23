<?php

/**
 * @var $this yii\web\View
 */

$this->title = Yii::t('hipanel/ticket', 'Update template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/ticket', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="service-update">
    <?= $this->render('_form', compact('models', 'model')) ?>
</div>
