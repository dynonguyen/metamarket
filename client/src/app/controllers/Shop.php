<?php
class Shop extends Controller
{
    public function index()
    {
        $this->setPageTitle('Kênh bán hàng');
        $this->render('layouts/shop');
    }

    public function addProduct()
    {
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', '/public/vendors/nicEdit/nicEdit.min.js']);
        $this->setContentViewPath('shop/add-product');
        $this->appendCssLink(['shop/add-product.css']);
        $this->appendJSLink(['shop/add-product.js']);
        $this->setPageTitle('Thêm sản phẩm');
        $this->render('layouts/shop');
    }

    public function postAddProduct()
    {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
    }
}
