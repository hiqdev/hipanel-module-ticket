<?php

/**
 * @var $this View
 * @var Article $model
 */

use hipanel\base\View;
use hipanel\widgets\Box;
use hisite\modules\news\models\Article;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]) ?>

    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                                 xmlns="http://www.w3.org/1999/html">
                                <?php
                                if ($model->isNewRecord) {
                                    $model->id = $i;
                                }
                                echo Html::activeHiddenInput($model, "[$i]id");
                                echo $form->field($model, "[$i]name");
                                echo $form->field($model, "[$i]is_published")->checkbox(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $data = $model->getAddedTexts();
                $j = 0;
                foreach ($data as $translation) { ?>
                    <div class="col-md-12">
                        <?php
                        $box = Box::begin(['renderBody' => false]);
                            $box->beginHeader();
                                echo $box->renderTitle(Yii::t('hipanel/ticket', 'Translation: {language}', [
                                    'language' => Yii::t('hipanel', $translation->lang)
                                ]));
                            $box->endHeader();
                            $box->beginBody();
                                if ($translation->isNewRecord) {
                                    $translation->article_id = $i;
                                }
                                echo Html::activeHiddenInput($translation, "[$i][$j]lang");
                                echo Html::activeHiddenInput($translation, "[$i][$j]article_id");
                                echo $form->field($translation, "[$i][$j]text")->textarea(['rows' => 6])->label(false);
                            $box->endBody();
                        $box->end(); ?>
                    </div>
                <?php $j++;

                } ?>

            </div>
        <?php } ?>
    </div>
<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end();
