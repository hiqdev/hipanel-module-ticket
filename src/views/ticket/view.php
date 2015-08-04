<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title                   = $model->threadViewTitle;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = StringHelper::truncateWords($model->threadViewTitle, 5);

$this->registerCss('
    .text-message {
        margin: 1rem;
    }
');
//\yii\helpers\VarDumper::dump($model, 10, true);
?>

<?php $form = ActiveForm::begin([
    'action' => $model->scenario === 'insert' ? Url::toRoute(['create']) : Url::toRoute([
        'update',
        'id' => $model->id,
    ]),
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'leave-comment-form'],
]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->render('_leftBlock', [
            'model'         => $model,
            'form'          => $form,
            'client'        => $client,
            'topic_data'    => $topic_data,
            'state_data'    => $state_data,
            'priority_data' => $priority_data,

        ]); ?>
    </div>
    <div class="col-md-9">
        <?= $this->render('_rightBlock', [
            'form'          => $form,
            'model'         => $model,
            'topic_data'    => $topic_data,
            'state_data'    => $state_data,
            'priority_data' => $priority_data,
        ]); ?>
    </div>
</div>
<?php $form::end(); ?>
