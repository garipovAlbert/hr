<?php

namespace common\components\sms;

use common\models\SmsLog;
use DOMDocument;
use DOMXPath;
use Exception;
use GuzzleHttp\Client;
use yii\base\Component;

/**
 * Description of Sms
 * @author Albert Garipov <bert320@gmail.com>
 */
class Sms extends Component
{

    public $url = 'https://www.smstraffic.ru/multi.php';

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * Sender name
     * @var string
     */
    public $originator;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->login === null) {
            throw new Exception('Login must be specified.');
        }
        if ($this->password === null) {
            throw new Exception('Password must be specified.');
        }
        if ($this->originator === null) {
            throw new Exception('Originator must be specified.');
        }
    }

    /**
     * Send the message
     * @param string $phone
     * @param string $message
     * @param boolean $supressError
     * @param array $params
     * @param type $buy_id
     * @return type
     * @throws Error
     */
    public function send($phone, $message, $supressError = false, array $params = [])
    {
        $params['login'] = $this->login;
        $params['password'] = $this->password;
        $params['phones'] = is_array($phone) ? join(',', $phone) : $phone;
        $params['message'] = $message;
        $params['rus'] = 5;
        $params['originator'] = $this->originator;
        $params['max_parts'] = 30;
        $params['want_sms_ids'] = 1;

        $response = (new Client())->post($this->url, [
            'form_params' => $params,
        ])
        ->getBody()
        ->getContents();

        // log
        $xml = new DOMDocument;
        $xml->preserveWhiteSpace = false;
        $xml->loadXML($response);
        /* $xml->loadXML('<?xml version="1.0"?><reply><result>OK</result><code>0</code><description>queued 1 messages</description></reply>'); */
        $xpath = new DOMXPath($xml);

        $mlog = new SmsLog();
        $mlog->result = $xpath->query('/reply/result')->item(0)->textContent;
        $mlog->code = $xpath->query('/reply/code')->item(0)->textContent;
        $mlog->message = $message;
        $mlog->description = $xpath->query('/reply/description')->item(0)->textContent;
//        $mlog->smsId = $xpath->query('/reply/message_infos/message_info/sms_id')->item(0)->textContent;
//        $mlog->phone = $xpath->query('/reply/message_infos/message_info/phone')->item(0)->textContent;
        $mlog->save(false);

        return $mlog;
    }

}