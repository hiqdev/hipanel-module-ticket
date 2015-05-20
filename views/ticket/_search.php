<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\combo\StaticCombo;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerJs(new JsExpression(<<<JS
// Button handle
$('.search-button').click(function(){
    $('.ticket-search').toggle();
    return false;
});
//
$('#search-form-ticket-pjax').on('pjax:end', function() {
    $.pjax.reload({container:'#ticket-grid-pjax', timeout: false});  //Reload GridView
});
JS
), \yii\web\View::POS_READY);
// \yii\helpers\VarDumper::dump($_GET['ThreadSearch']['watchers'], 10, true);
?>

<?php if (isset($_GET['ThreadSearch']['search_form']) && filter_var($_GET['ThreadSearch']['search_form'], FILTER_VALIDATE_BOOLEAN)) : ?>
    <div class="ticket-search row" style="margin-bottom: 20px;">
<?php else : ?>
    <div class="ticket-search row" style="margin-bottom: 20px; display: none;">
<?php endif; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'ticket-search',
        'action' => Url::to('index'),
        'method' => 'get',
        'options' => ['data-pjax' => true]
    ]); ?>
    <?= $form->field($model, 'search_form')->hiddenInput(['value' => 1])->label(false); ?>
    <div class="col-md-4">
        <?= $form->field($model, 'subject') ?>

        <div class="form-group">
            <?= Html::tag('label', 'Date range', ['class' => 'control-label']); ?>
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'time_from',
                // 'value' => date('d-m-Y'),
                'type' => DatePicker::TYPE_RANGE,
                'attribute2' => 'time_till',
                // 'value2' => date('d-m-Y'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy'
                ]
            ]); ?>
        </div>
        <?= $form->field($model, 'state')->widget(StaticCombo::classname(), [
            'data' => $state_data,
            'hasId' => true,
        ]); ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'author_id')->widget(ClientCombo::classname()); ?>

        <?= $form->field($model, 'responsible_id')->widget(ClientCombo::classname(), [
//            'clientType' => 'manager',
//            'pluginOptions' => [
//                'select2Options' => [
//                    'multiple' => true,
//                ],
//            ],
        ]); ?>

        <?= $form->field($model, 'topics')->widget(StaticCombo::classname(), [
            'data' => $topic_data,
            'hasId' => true,
            'pluginOptions' => [
                'select2Options' => [
                    'multiple' => true,
                ]
            ],
        ]); ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'recipient_id')->widget(ClientCombo::classname(), [
            'clientType' => 'client'
        ]); ?>

        <?= $form->field($model, 'priority')->widget(StaticCombo::classname(), [
            'data' => $priority_data,
        ]);?>

        <?php echo $form->field($model, 'watchers')->widget(ClientCombo::classname(), [
//            'pluginOptions' => [
//                'select2Options' => [
//                    'multiple' => true,
//                ],
//            ],
        ]); ?>
    </div>

    <div class="col-md-12">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
