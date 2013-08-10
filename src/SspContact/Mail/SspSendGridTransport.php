<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aramonc
 * Date: 8/10/13
 * Time: 5:34 PM
 * To change this template use File | Settings | File Templates.
 */

namespace SspContact\Mail;


use ApiConsumer\Consumer;
use Zend\Mail\Transport\TransportInterface;
use Zend\Mail;

class SspSendGridTransport implements TransportInterface
{

    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config['send_grid'];
    }

    /**
     * Send a mail message
     *
     * @param \Zend\Mail\Message $message
     * @return array
     */
    public function send(Mail\Message $message)
    {
        $consumer = new Consumer();
        $consumer->setUrl($this->config['url']);

        $params = array(
            'to' => urlencode($this->config['to']),
            'subject' => urlencode($message->getSubject()),
            'from' => urlencode($message->getFrom()->current()->getEmail()),
            'fromname' => urlencode($message->getFrom()->current()->getName()),
            'text' => urlencode($message->getBodyText()),
            'api_user' => urlencode($this->config['user']),
            'api_key' => urlencode($this->config['key']),
        );

        $bcc = $message->getBcc()->current();
        if($bcc) {
            $params['bcc'] = $bcc->getEmail();
        }

        $consumer->setParams($params);
        $consumer->setResponseType('json');
        $consumer->setCallType('get');

        return $consumer->doApiCall();

    }
}