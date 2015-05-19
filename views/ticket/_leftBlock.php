<?php
/**
 * @link http://hiqdev.com/...
 * @copyright Copyright (c) 2015 HiQDev
 * @license http://hiqdev.com/.../license
 */

use cebe\gravatar\Gravatar;
use frontend\assets\FlagIconCssAsset;
use hipanel\modules\ticket\widgets\Topic;
use hipanel\widgets\Box;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use hipanel\modules\ticket\widgets\Label;
//use hipanel\modules\ticket\widgets\Topic;
//use hipanel\modules\ticket\widgets\Watcher;
use hipanel\base\Re;
FlagIconCssAsset::register($this);
?>
<div class="row page-ticket">
    <div class="col-md-12">

        <?php $box = Box::begin([
            'options' => [
                'class' => 'box-solid'
            ],
        ]); ?>

        <?= $this->render('_advanced_form', [
            'form' => $form,
            'model' => $model,
            'topic_data' => $topic_data,
            'priority_data' => $priority_data,
            'state_data' => $state_data,
        ]); ?>


        <?php /*
        <?php if ($model->priority == 'medium') : ?>
            <?= Html::a('<span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;'.Yii::t('app', 'Increase'), ['priority-up', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        <?php else : ?>
            <?= Html::a('<span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;'.Yii::t('app', 'Lower'), ['priority-down', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        <?php endif; ?>
        */ ?>
        <?php /*
        <?php if ($model->state=='opened') : ?>
            <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('app', 'Close'), ['close', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to close this ticket?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php else : ?>
            <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('app', 'Open'), ['open', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-block',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to open this ticket?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        */ ?>

        <?php if (is_array($model->watchers)) : ?>
            <?= Html::tag('p', 'Watchers', ['class' => 'lead', 'style' => 'border-bottom: 1px solid #E1E1E1; margin-bottom: 0.5em;s']); ?>
            <div class="margin-bottom">
            <?php foreach ($model->watchers as $watcherId => $watcher) : ?>
                <?php
                $piece = explode(' ', $watcher);
                $watcherEmailHash = array_pop(explode(' ', $watcher));
                if ($watcherEmailHash) {
                    print Html::beginTag('a', [
                        'href' => Url::toRoute(['/client/client/view', 'id' => $watcherId]),
                    ]);
                    print Gravatar::widget([
                        'emailHash' => $watcherEmailHash,
                        'defaultImage' => 'identicon',
                        'options' => [
                            'alt' => reset($piece),
                            'class' => '',
                            'title' => reset($piece)
                        ],
                        'size' => 32,
                    ]);
                    print Html::endTag('a');
                }
                ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php $box->beginFooter(); ?>
        <?php if (is_array($model->watchers) && array_keys(Yii::$app->user->identity->id, $model->watchers)) : ?>
            <?= Html::a('<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;' . Yii::t('app', 'Unsubscribe'), ['unsubscribe', 'id' => $model->id], ['class' => 'btn  btn-default btn-block']) ?>
        <?php else : ?>
            <?= Html::a('<i class="fa fa-eye"></i>&nbsp;&nbsp;' . Yii::t('app', 'Subscribe'), ['subscribe', 'id' => $model->id], ['class' => 'btn  btn-default btn-block']) ?>
        <?php endif; ?>

        <?php $box->endFooter(); ?>

        <?php $box::end(); ?>
    </div>

    <div class="col-md-12">
        <?php /*
        <?php if (is_array($model->watcher) && in_array(Yii::$app->user->identity->username, $model->watcher)) : ?>
            <?= Html::a('<i class="fa fa-eye-slash"></i>&nbsp;&nbsp;'.Yii::t('app', 'Unsubscribe'), ['unsubscribe', 'id' => $model->id], ['class' => 'btn  btn-primary btn-block']) ?>
        <?php else : ?>
            <?= Html::a('<i class="fa fa-eye"></i>&nbsp;&nbsp;'.Yii::t('app', 'Subscribe'), ['subscribe', 'id' => $model->id], ['class' => 'btn  btn-primary btn-block']) ?>
        <?php endif; ?>

        <?php if ($model->priority == 'medium') : ?>
            <?= Html::a('<span class="glyphicon glyphicon-arrow-up"></span>&nbsp;&nbsp;'.Yii::t('app', 'Increase'), ['priority-up', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        <?php else : ?>
            <?= Html::a('<span class="glyphicon glyphicon-arrow-down"></span>&nbsp;&nbsp;'.Yii::t('app', 'Lower'), ['priority-down', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        <?php endif; ?>

        <?php if ($model->state=='opened') : ?>
            <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('app', 'Close'), ['close', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-block margin-bottom',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to close this ticket?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php else : ?>
            <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;'.Yii::t('app', 'Open'), ['open', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-block margin-bottom',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to open this ticket?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        */ ?>
        <?php $box = Box::begin([
            'options' => [
                'class' => 'box-solid'
            ],
        ]); ?>
        <div class="profile-block">
            <div class="profile-photo">
                <?php
                if ($model->author_email) {
                    print Gravatar::widget([
                        'emailHash' => $model->author_email,
                        'defaultImage' => 'identicon',
                        'options' => [
                            'alt' => '',
                            'class' => 'img-circle',
                        ],
                        'size' => 160,
                    ]);
                }
                ?>
            </div>
            <?= Html::tag('div', $model->author, ['class' => 'profile-user-name']); ?>
            <?= Html::tag('div', $model->author_seller, ['class' => 'profile-user-role']); ?>
        </div>
        <?php $box->beginFooter(); ?>
        <?= DetailView::widget([
            'model' => $client,
            'attributes' => [
                // 'subject',
                [
                    'attribute' => 'state',
                    'format' => 'html',
                    'value' => Html::tag('span', $client['state'], ['class' => 'label label-default'])
                ],
                [
                    'attribute' => 'balance',
                    'format' => 'html',
                    'value' => Topic::widget(['topics' => $model->topics]),
                    'visible' => $model->topics != null,
                ],
                [
                    'attribute' => 'credit',
                    'format' => 'html',
                    'value'=> Label::widget([
                        'type'=>'priority',
                        'label'=> Re::l($model->priority_label),
                        'value'=>$model->priority,
                    ])
                ],
                [
                    'attribute' => 'contact',
                    'label' => Yii::t('app', 'Country'),
                    'format' => 'html',
                    'value' => Html::tag('span', '', ['class' => 'flag-icon flag-icon-' . $client['contact']['country']]) . '&nbsp;&nbsp;' . $client['contact']['country_name']
                ],
                [
                    'attribute' => 'contact',
                    'label' => Yii::t('app', 'Email'),
                    'format' => 'html',
                    'value' => Html::mailto($client['contact']['email'], $client['contact']['email'])
                ],
//                // 'subject',
//                [
//                    'attribute'=>'state',
//                    'format'=>'html',
//                    'value'=>Label::widget([
//                        'type'=>'state',
//                        'label'=> Re::l($model->state_label),
//                        'value'=>$model->state,
//                    ]),
//                ],
//                [
//                    'attribute' => 'topics',
//                    'format'=>'html',
//                    'value' => Topic::widget(['topics' => $model->topics]),
//                    'visible' => $model->topics != null,
//                ],
//                [
//                    'attribute'=>'priority',
//                    'format'=>'html',
//                    'value'=> Label::widget([
//                        'type'=>'priority',
//                        'label'=> Re::l($model->priority_label),
//                        'value'=>$model->priority,
//                    ])
//                ],
//                [
//                    'attribute'=>'author',
//                    'format'=>'html',
//                    'value'=>Html::a($model->author,['/client/client/view','id'=>$model->author_id]),
//                ],
//                [
//                    'attribute'=>'responsible',
//                    'format'=>'html',
//                    'value'=>Html::a($model->responsible,['/client/client/view','id'=>$model->responsible_id]),
//                    'visible'=> $model->responsible != null,
//                ],
//                [
//                    'attribute'=>'recipient',
//                    'format'=>'html',
//                    'value'=>Html::a($model->recipient,['/client/client/view','id'=>$model->recipient_id]),
//                ],
//                [
//                    'attribute'=>'watcher',
//                    'format'=>'html',
//                    // 'value'=> Watcher::widget(['watchers'=>$model->watcher]),
//                    'visible'=> is_array($model->watcher)
//                ],
            ],
        ]); ?>
        <?php $box->endFooter(); ?>
        <?php $box::end(); ?>
    </div>
</div>