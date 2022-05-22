<?php
require_once _DIR_ROOT . '/utils/Image.php';

class Shop extends Controller
{

    public function index()
    {
        self::redirect('/kenh-ban-hang/don-hang/tat-ca');
    }

    // Order list
    public function orderList()
    {
        global $shop;

        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $query = http_build_query([
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE,
            'select' => '_id orderCode orderDate orderStatus orderTotal receiverName receiverPhone note',
            'sort' => '-orderDate',
            'where' => json_encode(['shopId' => $shop->_get('shopId')])
        ]);
        $apiRes = ApiCaller::get(ORDER_SERVICE_API_URL . "/list?$query");

        $orderDocs = [];
        if ($apiRes['statusCode'] === 200) {
            $orderDocs = $apiRes['data'];
        }

        $this->setViewContent('orderDocs', $orderDocs);
        $this->appendCssLink(['pagination.css']);
        $this->setPassedVariables(['ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL]);
        $this->appendJSLink(['pagination.js', 'utils/format.js', 'shop/order-list.js']);
        $this->setPageTitle('Danh sách đơn hàng');
        $this->setContentViewPath('shop/order-list');
        $this->render('layouts/shop', $this->data);
    }

    // Product
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

    // Chat, Support
    public function chat()
    {
        global $shop;
        $apiRes = ApiCaller::get(SUPPORT_SERVICE_API_URL . '/last-chats-by-shopId/' . $shop->_get('shopId'));
        $lastChats = [];
        if ($apiRes['statusCode'] === 200) {
            $lastChats = $apiRes['data'];
        }

        $this->setPageTitle('CSKH');
        $this->setViewContent('lastChats', $lastChats);

        $this->appendJSLink(['utils/format.js', 'shop/chat.js']);
        $this->appendCssLink(['chat-box.css', 'shop/chat.css']);
        $this->appendJsCDN([STATIC_FILE_URL . '/vendors/socket.io.min.js']);
        $this->setPassedVariables([
            'DEFAULT_SHOP_AVT' => DEFAULT_SHOP_AVT, 'STATIC_URL' => STATIC_FILE_URL,
            'SUPPORT_SERVICE_API_URL' => SUPPORT_SERVICE_API_URL,
            'USER_SERVICE_API_URL' => USER_SERVICE_API_URL,
            'CHAT_SOCKET_SERVER' => CHAT_SOCKET_SERVER,
            'SHOP_ID' => $shop->_get('shopId')
        ]);
        $this->setContentViewPath('shop/chat');
        $this->render('layouts/shop', $this->data);
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
        }

        if (!is_dir(_DIR_ROOT . "/public/upload/shop-$shopId/products")) {
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
