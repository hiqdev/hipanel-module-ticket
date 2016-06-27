<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 */

?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('author_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
</div>
