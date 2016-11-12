<?php

/* @var $this yii\web\View */

$this->title = Yii::t('hipanel:ticket', 'Create template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:ticket', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="template-create">
    <?= $this->render('_form', compact('models', 'model')) ?>
</div>
