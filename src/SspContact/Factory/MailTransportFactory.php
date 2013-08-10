<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aramonc
 * Date: 8/10/13
 * Time: 6:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace SspContact\Factory;


use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailTransportFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $transportClass = 'Zend\\Mail\\Transport\\Sendmail';
        if(isset($config['contact']['transport_class']) && class_exists($config['contact']['transport_class'], true)){
            $transportClass = $config['contact']['transport_class'];
        }
        return new $transportClass($config);
    }
}