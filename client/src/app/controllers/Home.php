<?php
class Home extends Controller
{
    public function index()
    {
        $this->setBasicData('home/index', 'Trang chủ');
        $this->render('layouts/main-layout', $this->data);

        $apiRes = ApiCaller::get(USER_SERVICE_API_URL . '/list');
        extract($apiRes);

        echo '<pre>';
        print_r($data);
        print_r($statusCode);
        print_r($error);
        echo '</pre>';
    }
}
