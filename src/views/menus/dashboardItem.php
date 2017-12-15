<?php

use hipanel\modules\dashboard\widgets\ObjectsCountWidget;
use hipanel\modules\dashboard\widgets\SmallBox;
use hipanel\modules\dashboard\widgets\SearchForm;
use hipanel\modules\ticket\models\ThreadSearch;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
    <?php $box = SmallBox::begin([
        'boxTitle' => Yii::t('hipanel', 'Tickets'),
        'boxIcon' => 'fa-ticket',
        'boxColor' => SmallBox::COLOR_ORANGE,
    ]) ?>
        <?php $box->beginBody() ?>
            <?= ObjectsCountWidget::widget([
                'totalCount' => $totalCount['tickets'],
                'ownCount' => $model->count['tickets'],
            ]) ?>
            <br>
            <br>
            <?= SearchForm::widget([
                'formOptions' => [
                    'id' => 'ticket-search',
                    'action' => Url::to('@ticket/index'),
                ],
                'model' => new ThreadSearch(),
                'attribute' => 'anytext_like',
                'buttonColor' => SmallBox::COLOR_ORANGE,
            ]) ?>
        <?php $box->endBody() ?>
        <?php $box->beginFooter() ?>
            <?= Html::a(Yii::t('hipanel', 'View') . $box->icon(), '@ticket/index', ['class' => 'small-box-footer']) ?>
            <?php if (Yii::$app->user->can('ticket.create')) : ?>
                <?= Html::a(Yii::t('hipanel', 'Create') . $box->icon('fa-plus'), '@ticket/create', ['class' => 'small-box-footer']) ?>
            <?php endif ?>
        <?php $box->endFooter() ?>
    <?php $box::end() ?>
</div>
