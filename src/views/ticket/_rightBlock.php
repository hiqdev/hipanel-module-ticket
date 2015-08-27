<?php

use hipanel\widgets\Box;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;
/*
$this->registerJs(new JsExpression(<<<'JS'
// Handle Hide
//$(".chats").on("click", ".hide-answer", function() {
//    var answer_id = $(this).data('answer-id');
//    console.log(answer_id);
//    $(this).parents('.message').find('.body, .attachment, .hide-answer, .show-answer').toggle('slow');
//});
//// Handle Show
//$(".chats").on("click", ".show-answer", function() {
//    var answer_id = $(this).data('answer-id');
//    console.log(answer_id);
//    $(this).parents('.message').find('.body, .attachment, .hide-answer, .show-answer').toggle('slow');
//});
// TODO: Handle Split
JS
    , View::POS_READY));
*/
?>

<!-- Chat box -->
<?php $box = Box::begin([
    'options' => [
        'class' => 'box-primary',
    ],
]) ?>

    <?= $this->render('_form', compact('form', 'model', 'topic_data', 'state_data', 'priority_data')) ?>
    <?php if (is_array($model->answers)) : ?>
        <hr class="no-panel-padding-h panel-wide padding-bottom">
        <div class="widget-article-comments tab-pane panel no-padding no-border fade in active">
            <?php foreach ($model->answers as $answer_id => $answer) : ?>
                <?php if (ArrayHelper::getValue($answer, 'message')) : ?>
                    <?= $this->render('_comment', ['model' => $model, 'answer_id' => $answer_id, 'answer' => $answer]) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php $box->end() ?><!-- /.box (chat box) -->
