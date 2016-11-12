<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\ticket\models\Thread;
use hiqdev\combo\StaticCombo;
use hiqdev\xeditable\widgets\ComboXEditable;
use hiqdev\xeditable\widgets\XEditable;
use yii\widgets\ActiveForm;

/**
 * @var Thread
 */
?>

<?php $form = ActiveForm::begin([
    'action'  => $action,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'leave-comment-form'],
]) ?>

    <!-- Topics -->
<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'topics')->widget(StaticCombo::class, [
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
        'data' => $topic_data,
    ]) ?>
<?php else : ?>
    <ul class="list-group ticket-list-group">
        <li class="list-group-item">
                <span class="badge">
                    <?= XEditable::widget([
                        'model' => $model,
                        'attribute' => 'topics',
                        'pluginOptions' => [
                            'disabled' => !Yii::$app->user->can('support'),
                            'type' => 'checklist',
                            'source' => $model->xFormater($topic_data),
                            'placement' => 'bottom',
                        ],
                    ]) ?>
                </span>
            <?= $model->getAttributeLabel('topics') ?>
            <div class="clearfix"></div>
        </li>
    </ul>
<?php endif ?>
    <div class="clearfix"></div>
    <!-- Priority -->
<?php if ($model->isNewRecord) : ?>
    <?php $model->priority = 'medium' ?>
    <?= $form->field($model, 'priority')->widget(StaticCombo::class, [
        'data' => $priority_data,
        'hasId' => true,
    ]) ?>
<?php else : ?>
    <ul class="list-group ticket-list-group">
        <li class="list-group-item">
                <span class="badge">
                    <?= XEditable::widget([
                        'model' => $model,
                        'attribute' => 'priority',
                        'pluginOptions' => [
                            'disabled' => !Yii::$app->user->can('support'),
                            'type' => 'select',
                            'source' => $priority_data,
                        ],
                    ]) ?>
                </span>
            <?= $model->getAttributeLabel('priority') ?>
        </li>
    </ul>
<?php endif ?>
<?php if (Yii::$app->user->can('support')) : ?>
    <?php if ($model->isNewRecord) : ?>
        <?php $model->responsible_id = Yii::$app->user->id ?>
        <!-- Responsible -->
        <?= $form->field($model, 'responsible')->widget(ClientCombo::class, [
            'clientType' => $model->getResponsibleClientTypes(),
        ]) ?>
    <?php else : ?>
        <ul class="list-group ticket-list-group">
            <li class="list-group-item">
                <span class="badge">
                    <?= ComboXEditable::widget([
                        'model' => $model,
                        'attribute' => 'responsible',
                        'combo' => [
                            'class' => ClientCombo::class,
                            'clientType' => $model->getResponsibleClientTypes(),
                            'inputOptions' => [
                                'class' => 'hidden',
                            ],
                            'pluginOptions' => [
                                'select2Options' => [
                                    'width' => '20rem',
                                ],
                            ],
                        ],
                        'pluginOptions' => [
                            'placement' => 'bottom',
                        ],
                    ]) ?>
                </span>
                <?= $model->getAttributeLabel('responsible') ?>
            </li>
        </ul>

        <ul class="list-group ticket-list-group">
            <?php /*<li class="list-group-item">
                <span class="badge">
                    <?= Gravatar::widget([
                        'emailHash' => $model->responsible_email,
                        'defaultImage' => 'identicon',
                        'size' => 16,
                        'options' => [
                            'alt' => '',
                            'class' => 'img-circle',
                        ],
                    ]) ?>
                    <?= Html::a($model->responsible, ['/client/client/view', 'id' => $model->responsible_id]) ?>
                </span>
                <?= $model->getAttributeLabel('responsible_id') ?>
            </li> */ ?>
            <li class="list-group-item">
                <span class="badge"><?= Yii::$app->formatter->asDuration($model->spent * 60) ?></span>
                <?= Yii::t('hipanel:ticket', 'Spent time') ?>
            </li>
        </ul>
    <?php endif ?>

    <!-- Watchers -->
    <?php if (Yii::$app->user->can('support')) : ?>
        <?php if ($model->isNewRecord) : ?>
            <?= $form->field($model, 'watchers')->widget(ClientCombo::class, [
                'clientType' => $model->getResponsibleClientTypes(),
                'pluginOptions' => [
                    'select2Options' => [
                        'multiple' => true,
                    ],
                ],
            ]) ?>
        <?php else: ?>
            <?php /*
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-4"><?= $model->getAttributeLabel('watchers') ?>:</div>
                        <div class="col-sm-8">
                            <span class="form-control-static">
                                <?php
                                $watchers = $model->watchers;
                                $model->watchers = $model->getWatchersLogin();
                                echo ComboXEditable::widget([
                                    'model' => $model,
                                    'attribute' => 'watchers',
                                    'combo' => [
                                        'class' => ClientCombo::class,
                                        'clientType' => ['manager', 'admin', 'owner'],
                                        'inputOptions' => [
                                            'class' => 'hidden'
                                        ],
                                        'pluginOptions' => [
                                            'select2Options' => [
                                                'multiple' => true,
                                                'width' => '20rem',
                                            ],
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'placement' => 'bottom',
                                    ],
                                ]);

                                $model->watchers = $watchers;
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            */ ?>
        <?php endif ?>
    <?php endif ?>
    <?php if ($model->isNewRecord) : ?>
        <?php $model->recipient_id = Yii::$app->user->identity->id ?>
        <?= $form->field($model, 'recipient_id')->widget(ClientCombo::class) ?>
    <?php endif ?>
<?php endif ?>

<?php $form->end() ?>
