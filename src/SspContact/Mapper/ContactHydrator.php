<?php

namespace SspContact\Mapper;

use SspContact\Entity\Contact as ContactEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

class ContactHydrator extends ClassMethods
{
    /**
     * @param ContactEntity $object
     * @throws \Exception
     * @return array
     */
    public function extract($object)
    {
        if(!$object instanceof ContactEntity) {
            throw new \Exception("$object must be an instance of SspContact\\Entity\\Contact.");
        }
        return $object->toArray();
    }

    /**
     * @param array $data
     * @param ContactEntity $object
     * @throws \Exception
     * @return ContactEntity
     */
    public function hydrate(array $data, $object)
    {
        if(!$object instanceof ContactEntity) {
            throw new \Exception("$object must be an instance of SspContact\\Entity\\Contact.");
        }
        $object->exchangeArray($data);
        return $object;
    }
}