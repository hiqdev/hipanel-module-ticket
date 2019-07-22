<?php

/**
 * @var \yii\web\View $this
 * @var Client $client
 */

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\stub\ClientRelationFreeStub;
use hipanel\widgets\ClientSellerLink;
use yii\helpers\Html;
use hipanel\widgets\MainDetails;

$this->registerCss('
.b-ticket-client-info table td {
    word-wrap: break-word; / All browsers since IE 5.5+ /
    overflow-wrap: break-word; / Renamed property in CSS3 draft spec /
}

.b-ticket-client-info .widget-user-header h4.widget-user-username {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
');

if ($client instanceof ClientRelationFreeStub) {
    $loader = $client->login !== 'anonym'
        ? \hipanel\widgets\AsyncLoader::widget([
            'route' => ['@ticket/render-client-info', 'id' => $client->id],
            'containerSelector' => '.b-ticket-client-info',
        ])
        : '';
}
if ($client->login !== 'anonym') {
    $linkToClient = Html::a(
        '<i class="fa fa-info-circle" style="font-size: 120%"></i> &nbsp;&nbsp;' . Yii::t('hipanel:ticket', 'Client details'),
        ['@client/view', 'id' => $client->id],
        ['class' => 'btn bg-olive btn-sm btn-block btn-flat']
    );
}
?>

<div class="col-md-12 b-ticket-client-info">
    <?= MainDetails::widget([
        'image' => $this->render('//layouts/gravatar', ['email' => $client->email, 'size' => 60, 'alt' => '']),
        'title' => ClientSellerLink::widget(['model' => $client]),
        'subTitle' => Yii::t('hipanel:client', ucfirst($client->type)),
        'menu' => '<div class="overlay-wrapper">' . $loader . '<div class="table-responsive ">' . ClientGridView::detailView([
                'model' => $client,
                'boxed' => false,
                'columns' => array_filter(
                    $client->login === 'anonym' ? ['name', 'email'] : [
                        'name', 'email', 'messengers', 'country', 'language', 'state',
                        Yii::$app->user->can('bill.read') ? 'balance' : null,
                        Yii::$app->user->can('bill.read') ? 'credit' : null,
                        'servers_spoiler', 'domains_spoiler', 'hosting',
                    ]
                ),
            ]) . '</div>' . $linkToClient . '</div>',
    ]) ?>
</div>

