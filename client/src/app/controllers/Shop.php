<?php
require_once _DIR_ROOT . '/utils/Image.php';
require_once _DIR_ROOT . '/app/models/Account.php';

class Shop extends Controller
{
    public function index()
    {
        self::redirect('/kenh-ban-hang/don-hang/tat-ca');
    }

    // Order list
    public function orderList($orderStatus = '')
    {
        global $shop;

        $where = ['shopId' => $shop->_get('shopId')];
        if (!empty($orderStatus)) {
            if ($orderStatus === 'pending_shop') {
                $where['orderStatus'] = ORDER_STATUS['PENDING_SHOP'];
            }
        }

        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $query = http_build_query([
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE,
            'select' => '_id orderCode orderDate orderStatus orderTotal receiverName receiverPhone note',
            'sort' => '-orderDate',
            'where' => json_encode($where)
        ]);
        $apiRes = ApiCaller::get(ORDER_SERVICE_API_URL . "/list?$query");

        $orderDocs = [];
        if ($apiRes['statusCode'] === 200) {
            $orderDocs = $apiRes['data'];
        }

        $this->setViewContent('orderDocs', $orderDocs);
        $this->appendCssLink(['pagination.css']);
        $this->setPassedVariables([
            'ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL,
            'PENDING_SHOP_STATUS' => ORDER_STATUS['PENDING_SHOP'],
            'SHIPPING_STATUS' => ORDER_STATUS['SHIPPING'],
        ]);
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

    public function productList()
    {
        global $shop;

        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sort = empty($_GET['s']) ? '' : $_GET['s'];
        $query = empty($_GET['q']) ? '' : $_GET['q'];
        $filter = empty($_GET['f']) ? '' : $_GET['f'];
        $query = http_build_query([
            'shopId' => $shop->_get('shopId'),
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE,
            'select' => '_id code name avt price discount unit stock purchaseTotal exp',
            'sort' => $sort,
            'query' => $query

        ]);
        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/list/by-shop?' . $query);
        $productDocs = [];

        if ($apiRes['statusCode'] === 200) {
            $productDocs = $apiRes['data'];
        }

        $this->setPassedVariables(['sort' => $sort]);
        $this->setPassedVariables(['filter' => $filter]);
        $this->setViewContent('productDocs', $productDocs);
        $this->appendCssLink(['product-card.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'shop/product-list.js']);
        $this->setContentViewPath('shop/product-list');
        $this->setPageTitle('Danh sách sản phẩm');
        $this->render('layouts/shop', $this->data);
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

    public function review()
    {
        global $shop;

        $apiRes = ApiCaller::get(REVIEW_SERVICE_API_URL . "/shop-review/" . $shop->_get('shopId'));
        $reviews = [];
        if ($apiRes['statusCode'] === 200) {
            $reviews = $apiRes['data'];
        }

        $this->setViewContent('reviews', $reviews);
        $this->setPageTitle('Đánh giá khách hàng');
        $this->setContentViewPath('shop/review');
        $this->render('layouts/shop', $this->data);
    }

    // Shop management
    public function information()
    {
        global $shop;

        $email = AccountModel::findEmailByAccountId($shop->_get('accountId'));

        $catalogName = '';
        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalog-name-by-id/' . $shop->_get('catalogId'));
        if ($apiRes['statusCode'] === 200) {
            $catalogName = $apiRes['data'];
        }

        $shopInfo = [
            'phone' => $shop->_get('phone'),
            'name' => $shop->_get('name'),
            'foundingDate' => $shop->_get('foundingDate'),
            'supporterName' => $shop->_get('supporterName'),
            'logoUrl' => $shop->_get('logoUrl'),
            'openHours' => $shop->_get('openHours'),
            'catalog' => $catalogName,
            'email' => $email
        ];

        $this->showSessionMessage();
        $this->setViewContent('shopInfo', $shopInfo);
        $this->setPageTitle('Thông tin cửa hàng');
        $this->setContentViewPath('shop/info');
        $this->render('layouts/shop', $this->data);
    }

    public function settings()
    {
        $this->showSessionMessage();
        $this->setPageTitle('Thiết lập cửa hàng');
        $this->appendJSLink(['shop/settings.js']);
        $this->setContentViewPath('shop/settings');
        $this->render('layouts/shop', $this->data);
    }

    public function postSettings()
    {
        global $shop;
        $updateData = [
            'name' => $shop->_get('name'),
            'phone' => $shop->_get('phone'),
            'supporterName' => $shop->_get('supporterName'),
            'openHours' => $shop->_get('openHours'),
            'logoUrl' => $shop->_get('logoUrl')
        ];

        if (!empty($_FILES['avt']) && !empty($_FILES['avt']['tmp_name'])) {
            $src = $_FILES['avt']['tmp_name'];

            // Remove old logo
            $oldLogoSrc = _DIR_ROOT . '/public/upload/shop-' . $shop->_get('shopId') . '/logo.*';
            array_map('unlink', glob($oldLogoSrc));

            // Create new image
            $type = str_replace('image/', '', $_FILES['avt']['type']);
            $updateData['logoUrl'] = 'upload/shop-' . $shop->_get('shopId') . "/logo.$type";
            move_uploaded_file($src, _DIR_ROOT . '/public/' . $updateData['logoUrl']);
        }
        if (!empty($_POST)) {
            $updateData['name'] = $_POST['name'];
            $updateData['phone'] = $_POST['phone'];
            $updateData['supporterName'] = $_POST['supporterName'];
            $updateData['openHours'] = $_POST['openHours'];
        }

        $isSuccess = ShopModel::updateShop($shop->_get('shopId'), $updateData);
        if ($isSuccess) {
            $this->setSessionMessage('Cập nhật thành công', false);
            self::redirect('/kenh-ban-hang/quan-ly/thong-tin');
        } else {
            $this->setSessionMessage('Cập nhật thất bại', true);
            self::redirect('/kenh-ban-hang/quan-ly/thiet-lap');
        }
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
