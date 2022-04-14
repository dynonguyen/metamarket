<?php
class CatalogModel
{
    private $_id;
    private $name;
    private $link;
    private $categories;

    public function __construct($_id, $name, $link, $categories)
    {
        $this->_id = $_id;
        $this->name = $name;
        $this->link = $link;
        $this->categories = $categories;
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
