<?php

namespace hipanel\modules\ticket\widgets;

use hipanel\modules\client\models\Article;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class TemplatesWidget extends Widget
{
    public $textareaSelector = '#thread-message';

    public function run()
    {
        if (!Yii::$app->user->can('support')) {
            return null;
        }

        $this->registerClientScript();

        return $this->render('templatesWidget', [
            'languages' => $this->getLanguages(),
            'defaultLanguage' => $this->getDefaultLanguage(),
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
        $result = [];

        $templates = Article::find()->ticketTemplates()->all();
        $data = ArrayHelper::getColumn($templates, 'data');

        foreach ($data as $languages) {
            foreach (array_keys($languages) as $code) {
                $result[$code] = [
                    'name' => Yii::t('hipanel', $code),
                    'code' => $code,
                ];
            }
        }

        return $result;
    }

    protected function registerClientScript()
    {
        $options = Json::encode([
            'url' => Url::to('@ticket/template-text'),
            'data' => [
                'id' => new JsExpression('id'),
                'lang' => new JsExpression('language'),
            ],
            'success' => new JsExpression("function (data) {
                if (data.text) {
                    var messageText = $('#thread-message').val();
                    if (messageText.length > 0) {
                        messageText = messageText + ' ';
                    }
                    $('$this->textareaSelector').val(messageText + data.text).trigger('blur').focus();
                }
            }")
        ]);

        $this->view->registerJs("
            $('#template-combo').on('select2-selecting', function (e) {
                var id = e.val;
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
}
