<?php

namespace SspContact\Mapper;

use SspContact\Entity\Contact as ContactEntity;
use ZfcBase\Mapper\AbstractDbMapper;

class Contact extends AbstractDbMapper
{

    protected $tableName = "contact";

    public function insert(ContactEntity $contact)
    {
        if($contact->getId() != null) {
            return $this->update($contact);
        }
        return parent::insert($contact);
    }

    public function update(ContactEntity $contact)
    {
        return parent::update($contact, array('id' => $contact->getId()));
    }
}