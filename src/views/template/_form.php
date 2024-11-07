<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\ticket\models\Template;
use hipanel\modules\ticket\models\Thread;
use hipanel\widgets\Box;
use hiqdev\combo\StaticCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Template $model
 * @var Template[] $models
 */

?>

<?php $form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]) ?>

<div class="container-items"><!-- widgetContainer -->
    <?php foreach ($models as $i => $model) : ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-instance">
                            <?php if ($model->isNewRecord) : ?>
                                <?php $model->id = $i ?>
                            <?php endif ?>
                            <?= $form->field($model, "[$i]id")->hiddenInput()->label(false) ?>
                            <?= $form->field($model, "[$i]name") ?>
                            <?= $form->field($model, "[$i]is_published")->checkbox() ?>
                            <?= $form->field($model, "[$i]topics")->widget(StaticCombo::class, [
                                'hasId' => true,
                                'data' => $model->getTopicOptions(),
                                'multiple' => true,
                            ]) ?>
                            <?= $form->field($model, "[$i]priority")->dropDownList($model->getPriorityOptions(), ['prompt' => '--']) ?>
                            <?= $form->field($model, "[$i]responsible")->widget(ClientCombo::class, [
                                'clientType' => Thread::getResponsibleClientTypes(),
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $data = $model->getAddedTexts() ?>
            <?php $j = 0 ?>
            <?php foreach ($data as $translation) : ?>
                <div class="col-md-12">
                    <?php $box = Box::begin(['renderBody' => false]); ?>
                    <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Yii::t('hipanel:ticket', 'Translation: {language}', [
                        'language' => Yii::t('hipanel', $translation->lang),
                    ])) ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                    <?php if ($translation->isNewRecord) : ?>
                        <?php $translation->article_id = $i ?>
                    <?php endif ?>
                    <?= $form->field($translation, "[$i][$j]lang")->hiddenInput()->label(false) ?>
                    <?= $form->field($translation, "[$i][$j]article_id")->hiddenInput()->label(false) ?>
                    <?= $form->field($translation, "[$i][$j]title")->label(Yii::t('hipanel:ticket', 'Subject')) ?>
                    <?= $form->field($translation, "[$i][$j]text")->textarea(['rows' => 6])->label(false) ?>
                    <?php $box->endBody() ?>
                    <?php $box->end() ?>
                </div>
                <?php ++$j ?>
            <?php endforeach ?>

        </div>
    <?php endforeach ?>
</div>
<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
&nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php $form::end() ?>
