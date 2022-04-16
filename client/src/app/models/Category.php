<?php
class CategoryModel
{
    use GetterSetter;

    private string $_id;
    private int $catalogId;
    private string $name;
    private string $link;

    public function __construct(int $catalogId, string $_id, string $name, string $link)
    {
        $this->_id = $_id;
        $this->catalogId = $catalogId;
        $this->name = $name;
        $this->link = $link;
    }
}
