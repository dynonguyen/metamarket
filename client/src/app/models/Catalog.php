<?php
class CatalogModel
{
    use GetterSetter;

    private string $_id;
    private string $name;
    private string $link;
    private array $categories;

    public function __construct(string $_id, string $name, string  $link, array $categories)
    {
        $this->_id = $_id;
        $this->name = $name;
        $this->link = $link;
        $this->categories = $categories;
    }
}
