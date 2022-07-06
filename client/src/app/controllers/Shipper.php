<?php

class Shipper extends Controller
{
    public function index()
    {
        self::redirect('kenh-van-chuyen/don-hang/tat-ca');
    }
    public function orderList()
    {
        $this->setPageTitle('Quản lý đơn hàng');
        $this->appendCssLink(['home.css', 'admin/shipper.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shop/order-list.js', 'search.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('shipper/order-list');
        $this->render('layouts/shipper', $this->data);
    }
}
