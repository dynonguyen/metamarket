<?php
class Home extends Controller
{
    public function index()
    {
        $this->setBasicData('home/index', 'Trang chủ');
        $this->render('layouts/main-layout', $this->data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://gateway:3000/api/v1/users/list");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $users = curl_exec($curl);
        $err = curl_error($curl);
        echo $err;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://gateway:3000/api/v1/products/list");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $products = curl_exec($curl);
        $err = curl_error($curl);
        echo $err;

        echo "<h2>Dữ liệu lấy từ 'User Service' nè</h2>";
        echo '<pre>';
        print_r($users);
        echo '</pre>';

        echo "<h2>Dữ liệu lấy từ 'Product Service' nè</h2>";
        echo '<pre>';
        print_r($products);
        echo '</pre>';
    }
}
