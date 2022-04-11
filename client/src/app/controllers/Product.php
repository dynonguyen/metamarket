<?php
class Product extends Controller
{
    public function index()
    {
        echo 'Sản phẩm nè';
    }

    public function list($id)
    {
        echo "List nè " . $id . $_GET["id"];
    }
}
