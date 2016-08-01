<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @var \hipanel\modules\ticket\models\Thread
 */
foreach ($model->answers as $answer_id => $answer) {
    if (!empty($answer->message)) {
        echo $this->render('_comment', ['model' => $model, 'answer_id' => $answer_id, 'answer' => $answer, 'client' => $client]);
    }
}
