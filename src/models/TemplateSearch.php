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

use hipanel\base\SearchModelTrait;
use Yii;

class TemplateSearch extends Template
{
    use SearchModelTrait;

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name_like' => Yii::t('hipanel:ticket', 'Name'),
            'author_id' => Yii::t('hipanel:ticket', 'Author'),
        ]);
    }
}
