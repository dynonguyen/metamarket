<?php
class CategoryModel
{
    private $_id;
    private $catalogId;
    private $name;
    private $link;

    public function __construct($catalogId, $_id, $name, $link)
    {
        $this->_id = $_id;
        $this->catalogId = $catalogId;
        $this->name = $name;
        $this->link = $link;
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
