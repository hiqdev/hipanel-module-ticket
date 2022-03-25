<?php

use hipanel\modules\ticket\widgets\TemplateCombo;
use yii\base\DynamicModel;
use yii\helpers\Html;

/**
 * @var \yii\web\View
 * @var array $languages
 * @var array $defaultLanguage
 * @var integer $formId
 */
?>

<div class="col-md-4 template-selector">
    <div class="form-group">
        <label class="control-label" for="thread-file"><?= Yii::t('hipanel:ticket', 'Template') ?></label>
        <div class="input-group">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="selected-language" data-language="<?= $defaultLanguage['code'] ?? '' ?>"><?= $defaultLanguage['name'] ?? '' ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="template-language">
                    <?php foreach ($languages as $language) : ?>
                        <?= Html::tag('li', Html::a($language['name'], '#', ['data-language' => $language['code']])) ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <?= TemplateCombo::widget([
                'model' => new DynamicModel(['template']),
                'attribute' => 'template',
                'inputOptions' => ['id' => $formId],
                'hasId' => true
            ]) ?>
        </div>
    </div>
</div>
