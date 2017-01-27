<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use hisite\modules\news\models\Article;
use Yii;

class Template extends Article
{
    public static $i18nDictionary = 'hipanel:ticket';

    public static function tableName()
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
            'name' => Yii::t('hipanel:ticket', 'Name'),
        ]);
    }
}
