<?php

use hipanel\helpers\Markdown;
use hipanel\modules\ticket\grid\TemplateGridView;
use hipanel\modules\ticket\menus\TemplateDetailMenu;
use hipanel\modules\ticket\models\Template;
use hipanel\widgets\Box;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Template $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:ticket', 'Answer templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]) ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-file-text-o fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
        </p>

        <div class="profile-usermenu">
            <?= TemplateDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>
            <?php $box = Box::begin(['renderBody' => false]) ?>
            <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:ticket', 'Template details')) ?>
            <?php $box->endHeader() ?>
            <?php $box->beginBody() ?>
                <?= TemplateGridView::detailView([
                    'model' => $model,
                    'boxed' => false,
                    'columns' => [
                        'author_id',
                        'name',
                        'is_published',
                    ],
                ]) ?>
            <?php $box->endBody() ?>
        <?php $box->end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php foreach ($model->texts as $translation) : ?>
                <div class="col-md-12">
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                        <?php $box->beginHeader() ?>
                            <?= $box->renderTitle(Yii::t('hipanel:ticket', 'Translation: {language}', [
                                'language' => Yii::t('hipanel', $translation->lang),
                            ])) ?>
                            <?php $box->endHeader() ?>
                            <?php $box->beginBody() ?>
                                <?php if (!empty($translation->text)) : ?>
                                    <?= Markdown::process($translation->text) ?>
                                <?php else: ?>
                                    <?= Html::tag('span', Yii::t('hipanel:ticket', 'No translation'), [
                                        'class' => 'text-danger',
                                    ]) ?>
                                <?php endif ?>
                        <?php $box->endBody() ?>
                    <?php $box->end() ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
