<?php
class Shop extends Controller
{
    public function index()
    {
        $this->setPageTitle('Kênh bán hàng');
        $this->render('layouts/shop');
    }
}
