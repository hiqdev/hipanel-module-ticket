<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\Gravatar;
use hiqdev\combo\StaticCombo;
use hiqdev\xeditable\widgets\XEditable;
use yii\helpers\Html;

?>
    <!-- Topics -->
<?php if ($model->isNewRecord) : ?>
    <?php
    $model->topics = 'general';
    print $form->field($model, 'topics')->widget(StaticCombo::className(), [
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
        'data' => $topic_data,
    ]); ?>
<?php else : ?>
    <?php
//    \yii\helpers\VarDumper::dump($model->state, 10, true);
//    \yii\helpers\VarDumper::dump($model->xFormater($topic_data), 10, true);
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= $model->getAttributeLabel('topics'); ?>:</label>
                <div class="col-sm-8">
                    <span class="form-control-static">
                        <?= XEditable::widget([
                            'model' => $model,
                            'attribute' => 'topics',
                            'value' => [2, 3],
                            'pluginOptions' => [
                                'type' => 'checklist',
                                'source' => $topic_data,
                                'placement' => 'bottom',
                            ],
                        ]); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <!-- State -->
            <?php if ($model->isNewRecord) : ?>
                <?php
                $model->state = 'opened';
                print $form->field($model, 'state')->widget(StaticCombo::classname(), [
                    'data' => $state_data,
                    'hasId' => true,
                ]);
                ?>
            <?php else : ?>
                <ul class="list-group ticket-list-group">
                    <li class="list-group-item">
                <span class="badge">
                    <?= XEditable::widget([
                        'model' => $model,
                        'attribute' => 'state',
                        'pluginOptions' => [
//                            'disabled' => !Yii::$app->user->can('own'),
                            'type' => 'select',
                            'source' => $state_data,
                        ],
                    ]); ?>
                </span>
                        <?= $model->getAttributeLabel('state'); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col-md-6 col-sm-12">
            <!-- Priority -->
            <?php if ($model->isNewRecord) : ?>
                <?php
                $model->priority = 'medium';
                print $form->field($model, 'priority')->widget(StaticCombo::classname(), [
                    'data' => $priority_data,
                    'hasId' => true,
                ]);
                ?>
            <?php else : ?>
                <ul class="list-group ticket-list-group">
                    <li class="list-group-item">
                <span class="badge">
                    <?= XEditable::widget([
                        'model' => $model,
                        'attribute' => 'priority',
                        'pluginOptions' => [
                            'type' => 'select',
                            'source' => $priority_data,
                        ],
                    ]); ?>
                </span>
                        <?= $model->getAttributeLabel('priority'); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>

<?php if (Yii::$app->user->can('support')) : ?>
    <?php if ($model->isNewRecord) : ?>
        <!-- Responsible -->
        <?= $form->field($model, 'responsible_id')->widget(ClientCombo::classname(), [
            'clientType' => ['manager', 'admin', 'owner'],
        ]); ?>
    <?php else : ?>
        <ul class="list-group ticket-list-group">
            <li class="list-group-item">
                <span class="badge">
                    <?= Gravatar::widget([
                        'emailHash' => $model->responsible_email,
                        'defaultImage' => 'identicon',
                        'size' => 16,
                        'options' => [
                            'alt' => '',
                            'class' => 'img-circle',
                        ],
                    ]); ?>
                    <?= Html::a($model->responsible, ['/client/client/view', 'id' => $model->responsible_id]); ?>
                </span>
                <?= $model->getAttributeLabel('responsible_id') ?>
            </li>
            <li class="list-group-item">
                <span class="badge"><?= $model->elapsed ?></span>
                <?= Yii::t('app', 'Spend time') ?>
            </li>
        </ul>
    <?php endif; ?>

    <?php if ($model->scenario === 'insert') : ?>
        <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
            'clientType' => ['manager', 'admin', 'owner'],
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ],
            ],
        ]); ?>
    <?php else : ?>
        <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
            'clientType' => ['manager', 'admin', 'owner'],
            'hasId' => true,
            'inputOptions' => [
                'value' => $model->watchers ? implode(',', array_keys($model->watchers)) : null,
            ],
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ],
            ],
        ]); ?>
    <?php endif; ?>

    <?php if ($model->isNewRecord) {
        $model->recipient_id = \Yii::$app->user->identity->id;
        print $form->field($model, 'recipient_id')->widget(ClientCombo::classname());
    } ?>
<?php endif; ?>