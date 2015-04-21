<?php
/**
 * @link    http://hiqdev.com/hipanel-module-ticket
 * @license http://hiqdev.com/hipanel-module-ticket/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\ticket\models;

use Yii;

class Ticket extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return $this->mergeAttributeLabels([
            'remoteid'              => Yii::t('app', 'Remote ID'),
        ]);
    }
}
