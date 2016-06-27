<?php

namespace hipanel\modules\ticket\models;

use hisite\modules\news\models\Article;
use Yii;

class Template extends Article
{
    public static $i18nDictionary = 'hipanel/ticket';

    public static function index()
    {
        return 'articles';
    }

    public static function type()
    {
        return 'article';
    }

    public function init()
    {
        $this->realm = 'ticket_template';
        $this->type = 'default';
    }

    public static function find($options = [])
    {
        return parent::find($options)->andWhere([
            'realm' => 'ticket_template',
        ]);
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name' => Yii::t('hipanel/ticket', 'Name'),
        ]);
    }
}
