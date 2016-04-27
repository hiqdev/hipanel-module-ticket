<?php

/**
 * @var \hipanel\modules\ticket\models\Thread $model
 */

foreach ($model->answers as $answer_id => $answer) {
    if (!empty($answer->message)) {
        echo $this->render('_comment', ['model' => $model, 'answer_id' => $answer_id, 'answer' => $answer]);
    }
}
