<?php

use hipanel\modules\client\widgets\combo\ClientCombo;

/**
 * @var \yii\web\View
 * @var \hipanel\widgets\AdvancedSearch $search
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('author_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
