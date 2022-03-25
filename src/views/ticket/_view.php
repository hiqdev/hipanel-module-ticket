<?php

/**
 * @var $this yii\web\View
 * @var $decorator \hipanel\modules\ticket\widgets\ThreadDecorator
 */

$params = [
    'form' => $form ?? null,
    'model' => $model ?? null,
    'client' => $client ?? null,
    'topic_data' => $topic_data ?? [],
    'state_data' => $state_data ?? [],
    'priority_data' => $priority_data ?? [],
    'action' => $action ?? '',
    'decorator' => $decorator ?? null,
];

?>

<div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
        <?= $this->render('_leftBlock', $params) ?>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
        <?= $this->render('_rightBlock', $params) ?>
    </div>
</div>
