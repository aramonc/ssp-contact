<?php

namespace SspContact\Mapper;

use SspContact\Entity\Contact as ContactEntity;
use ZfcBase\Mapper\AbstractDbMapper;

class Contact extends AbstractDbMapper
{

    protected $tableName = "contact";

    public function insert(ContactEntity $contact)
    {
        return parent::insert($contact);
    }
}