<?php
class Home extends Controller
{
    public function index()
    {
        $this->data['viewContent']['productData'] = [];
        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/homepage-products');
        if ($apiRes['statusCode'] === 200) {
            $this->data['viewContent']['productData'] = $apiRes['data'];
        }

        $this->setBasicData('home/index', 'Trang chủ');
        $this->data['cssLinks'] = ['home.css', 'product-card.css'];
        $this->data['jsLinks'] = ['utils/format.js', 'home.js', 'scroll-top.js'];
        $this->data['passedVariables'] = ['PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL];

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
