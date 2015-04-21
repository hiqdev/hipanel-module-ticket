<?php
/**
 * @link    http://hiqdev.com/hipanel-module-ticket
 * @license http://hiqdev.com/hipanel-module-ticket/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\ticket\grid\TicketGridView;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title                   = Html::encode($model->domain);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<? Pjax::begin(Yii::$app->params['pjax']) ?>
<div class="row">

<div class="col-md-4">
    <?= TicketGridView::detailView([
        'model'   => $model,
        'columns' => [
            'seller_id','client_id',
            ['attribute' => 'ticket'],
        ],
    ]) ?>
</div>

</div>
<?php Pjax::end() ?>
