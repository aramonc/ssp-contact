<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aramonc
 * Date: 8/10/13
 * Time: 3:02 PM
 * To change this template use File | Settings | File Templates.
 */

namespace SspContact\Factory;

use SspContact\Entity\Contact as ContactEntity;
use SspContact\Mapper\Contact as ContactMapper;
use SspContact\Mapper\ContactHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactMapperFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = new ContactMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'));
        $mapper->setEntityPrototype(new ContactEntity());
        $mapper->setHydrator(new ContactHydrator());
        return $mapper;

    }
}