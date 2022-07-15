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

        $shopsName = array();
        foreach ($apiRes['data']->docs as $myData) {
            $myApiRes = ApiCaller::get(SHOP_SERVICE_API_URL . "/by-id/$myData->shopId");
            array_push($shopsName, $myApiRes['data']->name);
        }

        $shippersName = array();
        foreach ($apiRes['data']->docs as $myData) {
            if ($myData->shipperId == -1) {
                array_push($shippersName, -1); // đơn hàng chưa có shipper
            } else {
                $myApiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . "shipper/by-id/$myData->shipperId");
                array_push($shippersName, $myApiRes['data']->username);
            }
        }

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('orderData', $apiRes['data']->docs);
            $this->setViewContent('shopsName', $shopsName);
            $this->setViewContent('shippersName', $shippersName);
        }

        $this->setPageTitle('Quản lý đơn hàng');
        $this->appendCssLink(['home.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'search.js']);
        $this->setPassedVariables(['ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL]);
        $this->setContentViewPath('shipper/order-list');
        $this->render('layouts/shipper', $this->data);
    }
}
