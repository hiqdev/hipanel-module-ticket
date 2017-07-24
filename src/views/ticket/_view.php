<?php

/**
 * @var $this yii\web\View
 * @var $decorator \hipanel\modules\ticket\widgets\ThreadDecorator
 */

?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_leftBlock',  compact('form', 'model', 'client', 'topic_data', 'state_data', 'priority_data', 'action', 'decorator')) ?>
    </div>
    <div class="col-md-9">
        <?= $this->render('_rightBlock', compact('form', 'model', 'client', 'topic_data', 'state_data', 'priority_data', 'action', 'decorator')) ?>
    </div>
</div>
