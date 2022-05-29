<?php
class Shipper extends Controller
{
    public function index()
    {
        $this->setViewContent('shipperData', []);
        $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/getallshipper');

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('shipperData', $apiRes['data']);
        }

        $this->setContentViewPath('shipper/index');
        $this->setPageTitle('Trang quản lý');
        $this->appendCssLink(['home.css', 'shipper/shipper.css']);
        $this->appendJSLink(['utils/format.js', 'home.js', 'scroll-top.js', 'search.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);

        $this->render('layouts/admin');
    }
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        if (empty($keyword)) {
            self::redirect('/');
            $this->setViewContent('shipperData', []);
            $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/searchshipper?keyword=' . str_replace(' ', '%20', $keyword));
            if ($apiRes['statusCode'] === 200) {
                $this->setViewContent('shipperData', $apiRes['data']);
            }
        }
        $this->setPageTitle('Trang quản lý');
        $this->appendCssLink(['home.css', 'shipper/shipper.css']);
        $this->appendJSLink(['utils/format.js', 'home.js', 'scroll-top.js', 'search.js']);
        $this->setPassedVariables(['INTERNAL_SERVICE_API_URL' => INTERNAL_SERVICE_API_URL]);
        echo "index dashboard shipper";
    }
}
