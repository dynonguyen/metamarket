<?php
class Home extends Controller
{
    public function index()
    {
        $this->setViewContent('productData', []);
        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/homepage-products');

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('productData', $apiRes['data']);
        }

        $this->setContentViewPath('home/index');
        $this->setPageTitle('Trang chủ');
        $this->appendCssLink(['home.css', 'product-card.css']);
        $this->appendJSLink(['utils/format.js', 'utils/product-mixin.js', 'utils/toast.js', 'home.js', 'scroll-top.js']);
        $this->setPassedVariables(['PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL]);

        $this->render('layouts/general', $this->data);
    }
}
