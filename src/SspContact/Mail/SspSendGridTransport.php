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

class SspSendGridTransport implements TransportInterface {

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
            'to' => $this->config['to'],
            'subject' => $message->getSubject(),
            'from' => $message->getFrom()->current()->getEmail(),
            'fromname' => $message->getFrom()->current()->getName(),
            'bcc' => $message->getBcc(),
            'text' => $message->getBodyText(),
        );

        $consumer->setParams($params);
        $consumer->setResponseType('json');
        $consumer->setCallType('get');

        return $consumer->doApiCall();

    }
}