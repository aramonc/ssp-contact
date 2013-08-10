<?php

namespace SspContact\Entity;


use Zend\Filter\Word\UnderscoreToCamelCase;

class Contact extends \ArrayObject
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $first_name;
    /**
     * @var string
     */
    public $last_name;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $message;
    /**
     * @var bool
     */
    public $is_active;
    /**
     * @var \DateTime
     */
    public $created;
    /**
     * @var \DateTime
     */
    public $modified;

    /**
     * @param string $created
     */
    public function setCreated($created)
    {
        try {
            $this->created = new \DateTime($created);
        } catch (\Exception $e) {
            $this->created = null;
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = intval($id);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = (bool) $is_active;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $modified
     */
    public function setModified($modified)
    {
        try {
            $this->created = new \DateTime($modified);
        } catch (\Exception $e) {
            $this->created = null;
        }
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $camelFilter = new UnderscoreToCamelCase();
        foreach($data as $prop => $value) {
            $method = 'set' . $camelFilter->filter($prop);
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $data['id'] = $this->getId();
        $data['first_name'] = $this->getFirstName();
        $data['last_name'] = $this->getLastName();
        $data['email'] = $this->getEmail();
        $data['subject'] = $this->getSubject();
        $data['message'] = $this->getMessage();
        $data['is_active'] = intval($this->getIsActive());
        $data['created'] = $this->getCreated()->format('Y-m-d H:i:s');
        $data['modified'] = $this->getModified()->format('Y-m-d H:i:s');

        return $data;
    }

}