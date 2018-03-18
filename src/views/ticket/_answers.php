<?php
/**
 * @var yii\web\View $this
 * @var hipanel\modules\ticket\models\Thread $model
 */

$this->registerCss(".ticket-answer-bg-grey { background-color: #f7f7f9; }");

?>

<?php foreach ($model->answers as $answer_id => $answer) : ?>
    <?php if (!empty($answer->message)) : ?>
        <?= $this->render('_answer', ['model' => $model, 'answer' => $answer]) ?>
    <?php endif ?>
<?php endforeach ?>
