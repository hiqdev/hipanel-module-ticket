<?php
/* @var $this yii\web\View */

$this->title                   = Yii::t('hipanel/ticket', 'Create template');
$this->breadcrumbs->setItems([['label' => Yii::t('hipanel/ticket', 'Templates'), 'url' => ['index']]]);
$this->breadcrumbs->setItems([$this->title]);
?>

<div class="template-create">
    <?= $this->render('_form', compact('models', 'model')) ?>
</div>
