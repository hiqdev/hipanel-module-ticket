<?php
/**
 * @var $this yii\web\View
 */

$this->title = Yii::t('hipanel/ticket', 'Update template');
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/ticket', 'Templates'), 'url' => ['index']],
    ['label' => $model->name, 'url' => ['view', 'id' => $model->id]],
    ['label' => $this->title],
]);
?>

<div class="service-update">
    <?= $this->render('_form', compact('models', 'model')) ?>
</div>
