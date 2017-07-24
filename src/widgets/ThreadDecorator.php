<?php

namespace hipanel\modules\ticket\widgets;

use hipanel\modules\ticket\models\Thread;
use Yii;
use yii\base\InvalidParamException;

/**
 * Class ThreadDecorator
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 *
 * @property string $subject
 */
class ThreadDecorator
{
    /**
     * @var Thread
     */
    private $thread;

    function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function __get($name)
    {
        if (method_exists($this, 'get' . ucfirst($name))) {
            return call_user_func([$this, 'get' . ucfirst($name)]);
        }

        return $this->thread->$name;
    }

    function __set($name, $value)
    {
        throw new InvalidParamException('Decorator should not be used for modifications');
    }

    public function getSubject()
    {
        $subject = $this->thread->subject;
        if (!empty($subject)) {
            return $subject;
        }

        return Yii::t('hipanel:ticket', '[No subject]');
    }
}
