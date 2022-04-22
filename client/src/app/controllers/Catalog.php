<?php
class Catalog extends Controller
{
    public function index($catalogLink)
    {
        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalog/id/' . $catalogLink);
        $catalogId = $apiRes['data'];
        $sort = empty($_GET['s']) ? '' : $_GET['s'];

        if ($apiRes['statusCode'] !== 200) {
            self::renderErrorPage('404');
        }

        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/list/catalog/' . $catalogId . '?select=_id%20name%20price%20unit%20avt%20discount&sort=' . $sort);
        $productDocs = $apiRes['data'];

        if ($apiRes['statusCode'] !== 200) {
            self::renderErrorPage('404');
        }

        $this->setViewContent('breadcrumbs', [
            ['link' => '/', 'name' => 'Trang chủ'],
            ['link' => '/', 'name' => 'Bánh kẹo - đồ ăn vặt']
        ]);

        $this->setPassedVariables(['sort' => $sort, 'PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL]);

        $this->setViewContent('productDocs', $productDocs);
        $this->setViewContent('sort', $sort);
        $this->setViewContent('catalogId', $catalogId);

        $this->setContentViewPath('catalog');
        $this->appendCssLink(['product-card.css']);
        $this->appendJSLink(['utils/format.js', 'utils/product-mixin.js', 'catalog-page.js']);
        $this->setPageTitle('Danh mục sản phẩm');
        $this->render('layouts/general', $this->data);
    }
}
