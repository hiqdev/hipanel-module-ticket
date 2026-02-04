<?php
/**
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket\models;

use hipanel\modules\client\models\Client;

trait ResponsibleTrait
{
    /**
     * Returns array of client types, that can be set as responsible for the thread.
     *
     * @return array
     */
    public static function getResponsibleClientTypes()
    {
        return [Client::TYPE_SELLER, Client::TYPE_ADMIN, Client::TYPE_MANAGER, Client::TYPE_OWNER];
    }
}
