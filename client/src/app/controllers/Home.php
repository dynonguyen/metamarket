<?php
class Home extends Controller
{
    public function index()
    {
        $apiRes = [];

        array_push($apiRes, ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(INTERNAL_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(ORDER_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(PAYMENT_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(PRODUCT_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(REVIEW_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(SHIPPING_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(SHOP_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(SUPPORT_SERVICE_API_URL . '/demo'));
        array_push($apiRes, ApiCaller::get(USER_SERVICE_API_URL . '/demo'));

        $this->data['viewContent']['data'] = $apiRes;

        $this->setBasicData('home/index', 'Trang chủ');
        $this->data['cssLinks'] = ['home.css'];
        $this->data['jsLinks'] = ['home.js', 'scroll-top.js'];
        $this->render('layouts/general', $this->data);
    }

    public function test()
    {
        $conn = MySQLConnection::getConnect();

        $query = $conn->query("SELECT * FROM accounts");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
