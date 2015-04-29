<?php
/**
 * Created by PhpStorm.
 * User: tofid
 * Date: 24.04.15
 * Time: 17:30
 */

namespace hipanel\modules\ticket\models;

use Yii;
use hipanel\modules\client\models\Client;

/**
 * Class TicketSettings
 * @package hipanel\modules\ticket\models
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
     * @return array
     */
    public function rules() {
        return [
            ['ticket_emails', 'string', 'max' => 128],
            ['ticket_emails', 'email'],
            ['send_message_text', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'ticket_emails' => Yii::t('app', 'Email for tickets'),
            'send_message_text' => Yii::t('app', 'Send message text'),
        ];
    }

    /**
     * Get form data from API
     */
    public function getFormData() {
        $data = Client::perform("GetClassValues", ["class" => "client,ticket_settings"], false);
        $this->ticket_emails = $data['ticket_emails'];
        $this->send_message_text = $data['send_message_text'];
    }

    /**
     * Set form data to API
     */
    public function setFormData() {
        Client::perform("SetClassValues", ["class" => "client,ticket_settings", 'values' => [
            'ticket_emails' => $this->ticket_emails,
            'send_message_text' => $this->send_message_text,
        ]]);
    }
}