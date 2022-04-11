<?php
class UserModel
{
    private $id;
    private $firstName;
    private $lastName;
    private $birthday;

    public function __construct($id, $firstName, $lastName, $birthday)
    {
        $this->id = $id;
        $this->$firstName = $firstName;
        $this->$lastName = $lastName;
        $this->birthday = $birthday;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
