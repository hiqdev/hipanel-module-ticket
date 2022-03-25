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


if ($client->login !== 'anonym') {
    if ($client instanceof ClientRelationFreeStub) {
        $loader = \hipanel\widgets\AsyncLoader::widget([
            'route' => ['@ticket/render-client-info', 'id' => $client->id],
            'containerSelector' => '.b-ticket-client-info',
        ]);
    }

    $linkToClient = Html::a(
        '<i class="fa fa-info-circle" style="font-size: 120%"></i> &nbsp;&nbsp;' . Yii::t('hipanel:ticket', 'Client details'),
        ['@client/view', 'id' => $client->id],
        ['class' => 'btn bg-olive btn-sm btn-block btn-flat']
    );
} else {
    $loader = '';
    $linkToClient = '';
}
?>

<div class="col-md-12 b-ticket-client-info">
    <?= MainDetails::widget([
        'image' => $this->render('//layouts/gravatar', ['email' => $client->email, 'size' => 60, 'alt' => '']),
        'title' => ClientSellerLink::widget(['model' => $client]),
        'subTitle' => Yii::t('hipanel:client', ucfirst((string)$client->type)),
        'menu' => (isset($loader) ? '<div class="overlay-wrapper">' . $loader . '<div class="table-responsive ">' : '') . ClientGridView::detailView([
                'model' => $client,
                'boxed' => false,
                'columns' => array_filter(
                    $client->login === 'anonym' ? ['name', 'email'] : [
                        'name', 'email', 'messengers', 'country', 'language', 'state',
                        Yii::$app->user->can('bill.read') ? 'balance' : null,
                        Yii::$app->user->can('bill.read') ? 'credit' : null,
                        class_exists(\hipanel\modules\server\Module::class) ? 'servers_spoiler' : null,
                        class_exists(\hipanel\modules\domain\Module::class) ? 'domains_spoiler' : null,
                        class_exists(\hipanel\modules\hosting\Module::class) ? 'hosting' : null,
                        class_exists(\hipanel\modules\finance\Module::class) && Yii::$app->user->can('plan.read') ? 'targets_spoiler' : null,
                    ]
                ),
            ]) . '</div>' . $linkToClient . '</div>',
    ]) ?>
</div>

