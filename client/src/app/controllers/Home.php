<?php
class Home extends Controller
{
    public function index()
    {
        $this->setBasicData('home/index', 'Trang chủ');
        $this->data['cssLinks'] = ['home.css'];
        $this->data['jsLinks'] = ['home.js', 'scroll-top.js'];
        $this->render('layouts/general', $this->data);
    }
}
