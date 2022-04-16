<?php
class CatalogModel
{
    use GetterSetter;

    private string $_id;
    private string $name;
    private string $link;
    private array $categories = [];

    public function __construct()
    {
    }
}
