<?php
class Product extends Controller
{
    public function index($productId)
    {
        if (empty($productId) || strlen($productId) !== 24) {
            self::renderErrorPage('404');
        }

        $this->setViewContent('breadcrumbs', [
            ['link' => '/', 'name' => 'Trang chủ'],
            ['link' => '#', 'name' => 'Nước giặt LIX đậm đặc 3.6kg/3,8kg'],
        ]);
        $this->setContentViewPath('product');
        $this->appendCssLink(['product.css', 'product-card.css']);
        $this->appendJSLink(['product.js']);
        $this->render('layouts/general', $this->data);
    }
}
