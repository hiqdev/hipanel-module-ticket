<?php

use hipanel\widgets\Box;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 */

$this->registerJs(<<<JS
$('.message-block-move-btn').on('click', function () {
    var button = $(this);
    var comment_tab = $('.comment-tab-wrapper');
    var comment_tab_sibling = comment_tab.prev();

    button.after(comment_tab);
    comment_tab_sibling.after(button);
    comment_tab.find('textarea').focus().trigger('focus');
});
JS
, View::POS_READY);

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
        <hr class="no-panel-padding-h panel-wide padding-bottom md-mb-0">
        <?= Html::button(Yii::t('hipanel/ticket', 'Answer'), ['class' => 'message-block-move-btn btn btn-default']); ?>
    <?php endif; ?>


<?php $box->end() ?><!-- /.box (chat box) -->
