<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use yii\base\InvalidCallException;
use yii\base\Widget;
use yii\widgets\ActiveForm;

/**
 * Class ConditionalFormWidget is designed for the following use case in ticket module:
 * On ticket create page all fields must be wrapped in single form,
 * however on the view page each block must be wrapped in a separate form in order to prevent
 * logical conflicts. With this widget we can use the same view files for both pages.
 *
 * Use example:
 *
 * ```php
 * // Use `$form` without any changes, or creates new one with `options`
 * $form = ConditionalFormWidget::begin([
 *     'form' => isset($form) ? $form : null,
 *     'options' => [
 *         'action'  => $action,
 *         'options' => ['enctype' => 'multipart/form-data'],
 *     ]
 * ]);
 *
 * $form->field($model, 'input');
 *
 * ConditionalFormWidget::end(); // Do not use $form->end() here!
 * ```
 *
 * IMPORTANT: the `::begin()` method returns instance of [[ActiveForm]] instead of this widget object.
 * Is is by design and done in order to give transparent variables.
 *
 * This class must be used only with `::begin()` and `::end()` methods.
 *
 * @author Dmitry Naumenko <d.naumenko.a@gmail.com>
 */
class ConditionalFormWidget extends Widget
{
    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var array options that will be used to create [[$form]] object
     */
    public $options;

    /**
     * @var boolean
     */
    protected $closeForm = false;

    /**
     * @param array $config
     * @return ActiveForm
     */
    public static function begin($config = [])
    {
        /** @var $widget static */
        $widget = parent::begin($config);

        return $widget->form;
    }

    /** {@inheritdoc} */
    public function init()
    {
        if (!isset($this->form)) {
            $this->closeForm = true;
            $this->form = ActiveForm::begin($this->options);
        }
    }

    /** {@inheritdoc} */
    public function run()
    {
        if ($this->closeForm) {
            $this->form->end();
        }
    }

    /**
     * @throws InvalidCallException
     * @internal
     */
    public static function widget($config = [])
    {
        throw new InvalidCallException('Class must be used with `::begin()` and `::end()` methods.');
    }
}
