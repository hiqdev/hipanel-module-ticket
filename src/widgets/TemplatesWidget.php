<?php declare(strict_types=1);
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\widgets;

use hipanel\modules\ticket\models\Template;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class TemplatesWidget extends Widget
{
    public $textareaSelector = '#thread-message';

    protected $formId;

    public function run()
    {
        if (!Yii::$app->user->can('ticket.read-templates')) {
            return null;
        }
        $this->formId = mt_rand();

        $this->registerClientScript();

        return $this->render('templatesWidget', [
            'languages' => $this->getLanguages(),
            'defaultLanguage' => $this->getDefaultLanguage(),
            'formId' => $this->formId,
        ]);
    }

    protected function getDefaultLanguage()
    {
        $languages = $this->getLanguages();
        $applicationLanguage = Yii::$app->language;

        if (isset($languages[$applicationLanguage])) {
            return $languages[$applicationLanguage];
        }

        $fallbackLanguage = substr($applicationLanguage, 0, 2);
        if (isset($languages[$fallbackLanguage])) {
            return $languages[$fallbackLanguage];
        }

        return reset($languages);
    }

    protected function getLanguages()
    {
        return Yii::$app->cache->getOrSet([__METHOD__, Yii::$app->user->getId()], function () {
            $result = [];

            $templates = Template::find()->joinWith('texts')->all();

            foreach (ArrayHelper::getColumn($templates, 'texts') as $texts) {
                foreach ($texts as $text) {
                    $result[$text->lang] = [
                        'name' => Yii::t('hipanel', $text->lang),
                        'code' => $text->lang,
                    ];
                }
            }

            return $result;
        }, 86400);
    }

    protected function registerClientScript()
    {
        $options = Json::encode([
            'url' => Url::to('@ticket/template/text'),
            'data' => [
                'id' => new JsExpression('id'),
                'lang' => new JsExpression('language'),
            ],
            'success' => new JsExpression("function (data) {
                if ('text' in data && data.text) {
                    var messageText = $('#thread-message').val();
                    if (messageText.length > 0) {
                        messageText = messageText + ' ';
                    }
                    $('$this->textareaSelector').val(messageText + data.text).trigger('blur').focus();
                }
                if('responsible' in data && data.responsible.length > 0) {
                    $('#thread-responsible').append(new Option(data.responsible, data.responsible, true, true)).trigger('change');
                }
                if('priority' in data && data.priority.length > 0) {
                    $('#thread-priority').val(data.priority).trigger('change');
                }
                if('topics' in data && data.topics.length > 0) {
                    $('#thread-topics').val(data.topics).trigger('change');
                }
            }"),
        ]);

        $this->view->registerJs("
            $('#$this->formId').on('select2:select', function (e) {
                var id = $(e.target).val();
                var language = $('.selected-language').attr('data-language');

                $.ajax($options);
            });
            $('.template-selector ul li>a').on('click', function (event) {
                var language = {
                    code: $(this).attr('data-language'),
                    name: $(this).text()
                };

                $('.template-selector .selected-language').text(language.name).attr('data-language', language.code);
                event.preventDefault();
            });
        ");
    }

    /**
     * @return mixed
     */
    public function getFormId()
    {
        return $this->formId;
    }
}
