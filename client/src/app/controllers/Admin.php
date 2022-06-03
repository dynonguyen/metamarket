<?php

class Admin extends Controller
{
    public function index()
    {
        self::redirect('kenh-quan-ly/shipper/tat-ca');
    }
    public function shipperlist()
    {
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $query = http_build_query([
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE
        ]);
        $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . "/get-all-shipper?$query");

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('shipperData', $apiRes['data']);
        }
        $this->setPageTitle('Quản lý shipper');
        $this->appendCssLink(['home.css', 'admin/shipper.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shop/order-list.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('admin/shipper-list');
        $this->render('layouts/admin', $this->data);
    }
}
