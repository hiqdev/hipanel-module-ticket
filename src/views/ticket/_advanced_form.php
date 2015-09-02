<?php
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\Gravatar;
use hiqdev\combo\ComboAsset;
use hiqdev\combo\StaticCombo;
use hiqdev\xeditable\widgets\ComboXEditable;
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
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= $model->getAttributeLabel('topics'); ?>:</label>

                <div class="col-sm-8">
                    <span class="form-control-static">
                        <?= XEditable::widget([
                            'model' => $model,
                            'attribute' => 'topics',
                            'pluginOptions' => [
                                'disabled' => !Yii::$app->user->can('support'),
                                'type' => 'checklist',
                                'source' => $model->xFormater($topic_data),
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
                            'disabled' => !Yii::$app->user->can('support'),
                            'type' => 'select',
                            'source' => $priority_data,
                        ],
                    ]); ?>
                </span>
            <?= $model->getAttributeLabel('priority'); ?>
        </li>
    </ul>
<?php endif; ?>
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
    <!-- Watchers -->
    <?php if (Yii::$app->user->can('support') && !$model->isNewRecord) : ?>
        <?php if ($model->isNewRecord) : ?>
            <?= $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
                'clientType' => ['manager', 'admin', 'owner'],
                'pluginOptions' => [
                    'select2Options' => [
                        'multiple' => true,
                    ],
                ],
            ]); ?>
        <?php else : ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label"><?= $model->getAttributeLabel('watchers'); ?>:</label>

                        <div class="col-sm-8">
                            <span class="form-control-static">
                                <?php
                                $watchers = $model->watchers;
                                $model->watchers = $model->getWatchersLogin();
                                echo ComboXEditable::widget([
                                    'model' => $model,
                                    'attribute' => 'watchers',
                                    'combo' => [
                                        'class' => ClientCombo::className(),
                                        'clientType' => ['manager', 'admin', 'owner'],
                                        'inputOptions' => [
                                            'class' => 'hidden'
                                        ],
                                        'pluginOptions' => [
                                            'select2Options' => [
                                                'multiple' => true,
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
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($model->isNewRecord) {
        $model->recipient_id = \Yii::$app->user->identity->id;
        print $form->field($model, 'recipient_id')->widget(ClientCombo::classname());
    } ?>
<?php endif; ?>