<?php

class Shipper extends Controller
{
    public function index()
    {
        self::redirect('kenh-van-chuyen/don-hang/tat-ca');
    }

    public function orderList()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $keyword = empty($_GET['keyword']) ? '' : (int)$_GET['keyword'];
        $query = http_build_query([
            'keyword' => $keyword,
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE
        ]);
        $apiRes = ApiCaller::get(ORDER_SERVICE_API_URL . "/list?$query");

        $shopName = array();
        foreach ($apiRes['data']->docs as $myData) {
            $shopsApiRes = ApiCaller::get(SHOP_SERVICE_API_URL . "/by-id/$myData->shopId");
            array_push($shopName, $shopsApiRes['data']->name);
        }

        $shipperName = array();
        foreach ($apiRes['data']->docs as $myData) {
            if ($myData->shipperId == -1) {
                array_push($shipperName, -1); // đơn hàng chưa có shipper
            } else {
                $shipperApiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . "/shipper/by-id/$myData->shipperId");
                array_push($shipperName, $shipperApiRes['data']->username);
            }
        }

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('page', $apiRes['data']->page);
            $this->setViewContent('totalPage', ceil($apiRes['data']->total / $apiRes['data']->pageSize));
            $this->setViewContent('orderData', $apiRes['data']->docs);
            $this->setViewContent('shopName', $shopName);
            $this->setViewContent('shipperName', $shipperName);
        }

        $this->setPageTitle('Quản lý đơn hàng');
        $this->appendCssLink(['home.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js']);
        $this->setPassedVariables(['ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL]);
        $this->setContentViewPath('shipper/order-list');
        $this->render('layouts/shipper', $this->data);
    }

    public function unconfirmedOrderList()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $keyword = empty($_GET['keyword']) ? '' : (int)$_GET['keyword'];
        $query = http_build_query([
            'keyword' => $keyword,
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE
        ]);
        $apiRes = ApiCaller::get(ORDER_SERVICE_API_URL . "/unconfirmed-list?$query");

        $shopName = array();
        foreach ($apiRes['data']->docs as $myData) {
            $shopApiRes = ApiCaller::get(SHOP_SERVICE_API_URL . "/by-id/$myData->shopId");
            array_push($shopName, $shopApiRes['data']->name);
        }

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('page', $apiRes['data']->page);
            $this->setViewContent('totalPage', ceil($apiRes['data']->total / $apiRes['data']->pageSize));
            $this->setViewContent('orderData', $apiRes['data']->docs);
            $this->setViewContent('shopName', $shopName);
        }

        $this->setPageTitle('Quản lý đơn hàng');
        $this->appendCssLink(['home.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shipper/unconfirmed-order-list.js']);
        $this->setPassedVariables(['ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL]);
        $this->setContentViewPath('shipper/unconfirmed-order-list');
        $this->render('layouts/shipper', $this->data);
    }

    public function updateOrder()
    {
        $this->setPageTitle('Quản lý đơn hàng');
        $this->appendCssLink(['home.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'search.js']);
        $this->render('layouts/shipper', $this->data);
    }
}
