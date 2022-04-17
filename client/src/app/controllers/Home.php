<?php
class Home extends Controller
{
    public function index()
    {
        $this->data['viewContent']['data'] = [];

        $this->setBasicData('home/index', 'Trang chủ');
        $this->data['cssLinks'] = ['home.css', 'product-card.css'];
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
