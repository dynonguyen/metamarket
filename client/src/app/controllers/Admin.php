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
        $keyword = empty($_GET['keyword']) ? '' : (int)$_GET['keyword'];
        $query = http_build_query([
            'keyword' => $keyword,
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE
        ]);
        $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . "/get-all-shipper?$query");

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('shipperData', $apiRes['data']);
        }
        $this->setPageTitle('Quản lý shipper');
        $this->appendCssLink(['home.css', 'admin/shipper.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shop/order-list.js', 'search.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('admin/shipper-list');
        $this->render('layouts/admin', $this->data);
    }
    public function viewAddShipper()
    {
        $this->renderviewAddShipper();
    }
    public function AddShipper()
    {
        $password = empty($_POST['password']) ? '123' : $_POST['password'];
        $hashPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);
        $data = [
            'shipperid' => empty($_POST['shipperid']) ? '' : $_POST['shipperid'],
            'username' => empty($_POST['username']) ? '' : $_POST['username'],
            'password' => $hashPwd,
            'peopleid' => empty($_POST['peopleid']) ? '' : $_POST['peopleid'],
            'address' => empty($_POST['address']) ? '' : $_POST['address'],
            'driverlicense' => empty($_POST['driverlicense']) ? '' : $_POST['driverlicense'],
        ];
        $apiRes = ApiCaller::post(INTERNAL_SERVICE_API_URL . '/shipper/add', $data);
        if ($apiRes['statusCode'] === 200 || $apiRes['statusCode'] === 201) {
            $this->setViewContent('isError', false);
        } else {
            $this->setViewContent('isError', true);
        }
        $this->renderviewAddShipper();
    }
    private function renderviewAddShipper()
    {
        $this->setPageTitle('Quản lý shipper');
        $this->setPassedVariables(['STATIC_FILE_URL' => STATIC_FILE_URL]);
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', '/public/vendors/nicEdit/nicEdit.min.js']);
        $this->appendCssLink(['home.css', 'admin/shipper.css',]);
        $this->appendJSLink(['utils/format.js', 'admin/shipper.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        $this->setContentViewPath('admin/add-shipper');
        $this->render('layouts/admin');
    }
}
