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

use hipanel\modules\client\models\Client;
use Yii;

/**
 * Class TicketSettings.
 */
class TicketSettings extends \hipanel\base\Model
{
    /**
     * @var
     */
    public $ticket_emails;

    /**
     * @var
     */
    public $send_message_text;

    /**
     * @var boolean
     */
    public $new_messages_first;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['ticket_emails', 'string', 'max' => 128],
            ['ticket_emails', 'email'],
            ['send_message_text', 'boolean'],
            ['new_messages_first', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'ticket_emails'     => Yii::t('hipanel:ticket', 'Email for tickets'),
            'send_message_text' => Yii::t('hipanel:ticket', 'Send message text'),
            'new_messages_first' => Yii::t('hipanel:ticket', 'New messages first'),
        ];
    }

    /**
     * Get form data from API.
     */
    public function getFormData()
    {
        $data                    = Client::perform('get-class-values', ['class' => 'client,ticket_settings']);
        $this->ticket_emails     = $data['ticket_emails'];
        $this->send_message_text = $data['send_message_text'];
        $this->new_messages_first = $data['new_messages_first'];
    }

    /**
     * Set form data to API.
     */
    public function setFormData()
    {
        Client::perform('set-class-values', [
            'class' => 'client,ticket_settings',
            'values' => [
                'ticket_emails'     => $this->ticket_emails,
                'send_message_text' => $this->send_message_text,
                'new_messages_first' => $this->new_messages_first,
            ],
        ]);
    }
}
