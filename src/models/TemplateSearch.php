<?php

namespace hipanel\modules\ticket\models;

use hipanel\base\SearchModelTrait;
use Yii;

class TemplateSearch extends Template
{
    use SearchModelTrait;

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name_like' => Yii::t('hipanel/ticket', 'Name'),
            'author_id' => Yii::t('hipanel/ticket', 'Author'),
        ]);
    }
}
