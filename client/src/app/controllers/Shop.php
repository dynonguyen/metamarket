<?php
require_once _DIR_ROOT . '/utils/Image.php';

class Shop extends Controller
{
    public function index()
    {
        $this->setPageTitle('Kênh bán hàng');
        $this->render('layouts/shop');
    }

    public function addProduct()
    {
        $this->renderAddProductPage();
    }

    public function postAddProduct()
    {
        global $shop;
        $shopId = $shop->_get('shopId');

        // catalog
        $catalog = empty($_POST['catalog']) ? '' : $_POST['catalog'];
        [0 => $catalogId, 1 => $categoryId] = explode('/', $catalog);

        // infos
        $infos = empty($_POST['infos']) ? [] : array_values($_POST['infos']);

        // product code
        $productCode = strtoupper(uniqid($shopId));

        // avt
        $avtSrc = $this->uploadProductPhoto($_FILES['avt']['tmp_name'], 'avt',  str_replace('image/', '', $_FILES['avt']['type']), $shopId, $productCode, 260);

        // photos
        $photos = [];
        if (!empty($_FILES['photos'])) {
            $len = sizeof($_FILES['photos']['tmp_name']);
            for ($i = 0; $i < $len; ++$i) {
                $src = $this->uploadProductPhoto($_FILES['photos']['tmp_name'][$i], strval($i + 1), str_replace('image/', '', $_FILES['photos']['type'][$i]), $shopId, $productCode, 80);
                array_push($photos, $src);
            }
        }

        // form data
        $data = [
            'catalogId' => $catalogId,
            'categoryId' => (int)$categoryId,
            'name' => empty($_POST['name']) ? '' : $_POST['name'],
            'price' => empty($_POST['price']) ? 0 : (int)$_POST['price'],
            'shopId' => $shopId,
            'code' => $productCode,
            'stock' => empty($_POST['stock']) ? 0 : (int)$_POST['stock'],
            'discount' => empty($_POST['discount']) ? 0 : (int)$_POST['discount'],
            'unit' => empty($_POST['unit']) ? 'Sản phẩm' : $_POST['unit'],
            'avt' => str_replace(_DIR_ROOT . '/public/', '', $avtSrc),
            'mfg' => empty($_POST['mfg']) ? strval(date("Y-m-d")) : $_POST['mfg'],
            'exp' => empty($_POST['exp']) ? strval(date("Y-m-d")) : $_POST['exp'],

            'origin' => empty($_POST['origin']) ? '' : $_POST['origin'],
            'brand' => empty($_POST['brand']) ? '' : $_POST['brand'],
            'desc' => empty($_POST['desc']) ? '' : $_POST['desc'],
            'infos' => $infos,
            'photos' => $photos
        ];

        $apiRes = ApiCaller::post(PRODUCT_SERVICE_API_URL . '/add-product', $data);
        if ($apiRes['statusCode'] === 200 || $apiRes['statusCode'] === 201) {
            $this->setViewContent('isError', false);
        } else {
            $this->setViewContent('isError', true);
            // Remove photos
            $path = _DIR_ROOT . "/public/upload/shop-$shopId/products/$productCode";
            if (is_dir($path)) {
                rmdir($path);
            }
        }

        $this->appendJSLink('utils/toast.js');
        $this->renderAddProductPage();
    }

    // private method
    private function renderAddProductPage()
    {
        // Get catalog options
        $catalogApi = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalogs?select=-link%20-categories.link');
        $catalogs = [];
        if ($catalogApi['statusCode'] === 200) {
            $catalogs = $catalogApi['data'];
        }

        $this->setViewContent('catalogs', $catalogs);
        $this->setPassedVariables(['STATIC_FILE_URL' => STATIC_FILE_URL]);
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', '/public/vendors/nicEdit/nicEdit.min.js']);
        $this->setContentViewPath('shop/add-product');
        $this->appendCssLink(['shop/add-product.css']);
        $this->appendJSLink(['shop/add-product.js']);
        $this->setPageTitle('Thêm sản phẩm');
        $this->render('layouts/shop');
    }

    private function uploadProductPhoto($source, $filename, $filetype, $shopId, $productCode, $thumbSize = 260)
    {
        $folderPath = _DIR_ROOT . "/public/upload/shop-$shopId/products/" . $productCode;
        $fullPath =  $folderPath . "/$filename." . $filetype;
        $thumbFullPath =  $folderPath . "/$filename" . "_thumb.$filetype";

        if (!is_dir(_DIR_ROOT . "/public/upload/shop-$shopId")) {
            mkdir(_DIR_ROOT . "/public/upload/shop-$shopId");
            mkdir(_DIR_ROOT . "/public/upload/shop-$shopId/products");
        }

        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        ImageUtil::compressImage($source, $fullPath, 80);
        ImageUtil::createThumbnail($source, $thumbFullPath, $thumbSize);

        return str_replace(_DIR_ROOT . "/public/", '', $fullPath);
    }
}
