<?php
class Product extends Controller
{
    public function index($productId)
    {
        if (empty($productId) || strlen($productId) !== 24) {
            self::renderErrorPage('404');
        }

        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/product-details/' . $productId);
        if ($apiRes['statusCode'] === 200) {
            $data = $apiRes['data'];
            $productName = $data->product->name;
            $catalog = $data->product->catalogId->name;
            $catalogLink = $data->product->catalogId->link;

            $this->setViewContent('product', $data->product);
            $this->setViewContent('productDetail', $data->productDetail);
            $this->setViewContent('shop', $data->shop);
            $this->setViewContent('reviews', $data->reviews);
            $this->setViewContent('otherProducts', $data->otherProducts);

            $this->setViewContent('breadcrumbs', [
                ['link' => '/', 'name' => 'Trang chủ'],
                ['link' => "/catalog/$catalogLink", 'name' => $catalog],
                ['link' => '#', 'name' => $productName],
            ]);
            $this->setContentViewPath('product');
            $this->appendCssLink(['product.css', 'product-card.css']);
            $this->appendJSLink(['product.js']);
            $this->setPageTitle($productName);
            $this->render('layouts/general', $this->data);
        } else {
            error_log($apiRes['error']);
            self::renderErrorPage('404');
        }
    }
}
