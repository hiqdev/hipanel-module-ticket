<?php

use hipanel\helpers\Markdown;
use hipanel\modules\ticket\grid\TemplateGridView;
use hipanel\modules\ticket\models\Template;
use hipanel\widgets\Box;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

/**
 * @var Template $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:ticket', 'Answer templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(Yii::$app->params['pjax']) ?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding'
            ]
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-file-text-o fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li><?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('hipanel', 'Update'), ['update', 'id' => $model->id]) ?></li>
            </ul>
        </div>
        <?php Box::end(); ?>
        <?php
        $box = Box::begin(['renderBody' => false]);
            $box->beginHeader();
                echo $box->renderTitle(Yii::t('hipanel:ticket', 'Template details'));
            $box->endHeader();
            $box->beginBody();
                echo TemplateGridView::detailView([
                    'model' => $model,
                    'boxed' => false,
                    'columns' => [
                        'author_id',
                        'name',
                        'is_published',
                    ],
                ]);
            $box->endBody();
        $box->end();
        ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php foreach ($model->texts as $translation) { ?>
                <div class="col-md-12">
                    <?php
                    $box = Box::begin(['renderBody' => false]);
                        $box->beginHeader();
                            echo $box->renderTitle(Yii::t('hipanel:ticket', 'Translation: {language}', [
                                'language' => Yii::t('hipanel', $translation->lang)
                            ]));
                        $box->endHeader();
                        $box->beginBody();
                            if (!empty($translation->text)) {
                                echo Markdown::process($translation->text);
                            } else {
                                echo Html::tag('span', Yii::t('hipanel:ticket', 'No translation'), [
                                    'class' => 'text-danger'
                                ]);
                            }
                        $box->endBody();
                    $box->end();
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php Pjax::end() ?>
