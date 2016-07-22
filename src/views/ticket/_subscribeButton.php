<?php

use hipanel\helpers\HtmlHelper;
use hipanel\helpers\Url;
use hipanel\widgets\Gravatar;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin(array_merge(Yii::$app->params['pjax'], [
    'id' => 'ticketSubscribeButton',
    'enablePushState' => false,
    'clientOptions'   => [
        'type' => 'POST',
        'data' => [
            "{$model->formName()}[id]" => $model->id,
        ],
    ],
]));

if (is_array($model->watchers)) {
    echo Html::tag('p', Yii::t('hipanel/ticket', 'Watchers'), ['class' => 'lead', 'style' => 'border-bottom: 1px solid #E1E1E1; margin-bottom: 0.5em;']);
    ?>
    <div class="margin-bottom">
        <?php foreach ($model->watchers as $watcherId => $watcher) {
    $piece            = explode(' ', $watcher);
    $watcherEmailHash = array_pop(explode(' ', $watcher));
    if ($watcherEmailHash) {
        echo Html::beginTag('a', ['href' => Url::toRoute(['@client/view', 'id' => $watcherId])]);
        echo Gravatar::widget([
                    'emailHash'    => $watcherEmailHash,
                    'options'      => [
                        'class' => 'img-circle',
                        'title' => reset($piece),
                        'alt'   => reset($piece),
                    ],
                    'size' => 32,
                ]);
        echo Html::endTag('a');
    }
}
    ?>
    </div>
<?php

}

$subscribed = array_key_exists(Yii::$app->user->identity->id, $model->watchers ?: []);
if ($subscribed) {
    $action = ['unsubscribe', 'id' => $model->id];
    $label = '<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;' . Yii::t('hipanel/ticket', 'Unsubscribe');
} else {
    $action = ['subscribe', 'id' => $model->id];
    $label = '<i class="fa fa-eye"></i>&nbsp;&nbsp;' . Yii::t('hipanel/ticket', 'Subscribe');
}

echo Html::a($label, $action, HtmlHelper::loadingButtonOptions(['class' => 'btn btn-default btn-sm btn-block']));

Pjax::end();
