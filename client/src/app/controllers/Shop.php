<?php
require_once _DIR_ROOT . '/utils/Image.php';
require_once _DIR_ROOT . '/app/models/Account.php';
require_once _DIR_ROOT . '/utils/Format.php';

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

        // Get catalog options
        $catalogApi = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalogs?select=-link%20-categories.link');
        $catalogs = [];
        if ($catalogApi['statusCode'] === 200) {
            $catalogs = $catalogApi['data'];
        }

        // Get products list by shopId
        $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
        $sort = empty($_GET['s']) ? '' : $_GET['s'];
        $query = empty($_GET['q']) ? '' : $_GET['q'];
        $filter = empty($_GET['f']) ? '' : $_GET['f'];
        $query = http_build_query([
            'shopId' => $shop->_get('shopId'),
            'page' => $page,
            'pageSize' => DEFAULT_PAGE_SIZE,
            'select' => '_id code name avt price discount unit stock purchaseTotal exp catalogId categoryId',
            'sort' => $sort,
            'query' => $query

        ]);
        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/list/by-shop?' . $query);
        $productDocs = [];

        if ($apiRes['statusCode'] === 200) {
            $productDocs = $apiRes['data'];
        }

        // Get product-details by productId in the above list
        $productDetailList = array();

        foreach ($productDocs->docs as $pDoc) {
            $queryProductDetails = $pDoc->_id;
            $productDetailList[] = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/product-details/' . $queryProductDetails);
        }

        $this->showSessionMessage();
        $this->setViewContent('catalogs', $catalogs);
        $this->setViewContent('productDocs', $productDocs);
        $this->setViewContent('productDetailList', $productDetailList);
        $this->setPassedVariables(['sort' => $sort]);
        $this->setPassedVariables(['filter' => $filter]);
        $this->setPassedVariables(['STATIC_FILE_URL' => STATIC_FILE_URL]);
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', '/public/vendors/nicEdit/nicEdit.min.js']);
        $this->setContentViewPath('shop/product-list');
        $this->appendCssLink(['product-card.css', 'product-modal.css', 'pagination.css']);
        $this->appendJSLink(['pagination.js', 'shop/product-list.js']);
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

    public function postUpdateProduct()
    {
        global $shop;
        $shopId = $shop->_get('shopId');

        // catalog
        $catalog = empty($_POST['catalog']) ? '' : $_POST['catalog'];
        [0 => $catalogId, 1 => $categoryId] = explode('/', $catalog);

        // form data
        $updateData = [
            'catalogId' => $catalogId,
            'categoryId' => (int)$categoryId,
            'productId' => empty($_POST['_id']) ? '' : $_POST['_id'],
            'code' => empty($_POST['code']) ? '' : $_POST['code'],
            'name' => empty($_POST['name']) ? '' : $_POST['name'],
            'price' => empty($_POST['price']) ? 0 : (int)$_POST['price'],
            'stock' => empty($_POST['stock']) ? 0 : (int)$_POST['stock'],
            'discount' => empty($_POST['discount']) ? 0 : (int)$_POST['discount'],
            'unit' => empty($_POST['unit']) ? 'Sản phẩm' : $_POST['unit'],
            'avt' => empty($_POST['avt']) ? '' : $_POST['avt'],
            'origin' => empty($_POST['origin']) ? '' : $_POST['origin'],
            'brand' => empty($_POST['brand']) ? '' : $_POST['brand'],
            'currentPhotos' => empty($_POST['currentPhotos']) ? [] : $_POST['currentPhotos'],
            'removePhotos' => empty($_POST['removePhotos']) ? [] : $_POST['removePhotos'],
            'removeThumbPhotos' => empty($_POST['removeThumbPhotos']) ? [] : $_POST['removeThumbPhotos'],
            'addPhotos' => empty($_POST['photos']) ? [] : $_POST['photos'],
            'productPhotos' => [],
            'desc' => empty($_POST['desc']) ? '' : $_POST['desc'],
        ];

        // Edit product avt
        if (!empty($_FILES['avt']) && !empty($_FILES['avt']['tmp_name'])) {
            // Remove old avt
            $oldAvtSrc = _DIR_ROOT . '/public/upload/shop-' . $shop->_get('shopId') . '/products/' . $updateData['code'] . '/avt.*';
            array_map('unlink', glob($oldAvtSrc));

            // Remove old thumb avt
            $oldThumbAvtSrc = _DIR_ROOT . '/public/upload/shop-' . $shop->_get('shopId') . '/products/' . $updateData['code'] . '/avt_thumb.*';
            array_map('unlink', glob($oldThumbAvtSrc));

            // Create new avt and thumb avt
            $avtSrc = $this->uploadProductPhoto($_FILES['avt']['tmp_name'], 'avt',  str_replace('image/', '', $_FILES['avt']['type']), $shop->_get('shopId'), $updateData['code'], 260);
            $updateData['avt'] = str_replace(_DIR_ROOT . '/public/', '', $avtSrc);
        }

        // Remove chosen photos
        if (!empty($updateData['removePhotos'])) {
            $currentPhotosLen = count($updateData['currentPhotos']);
            $removePhotosLen = count($updateData['removePhotos']);
            for ($i = 0; $i < $currentPhotosLen; $i++) {
                for ($j = 0; $j < $removePhotosLen; $j++) {
                    if ($updateData['removePhotos'][$j] == $updateData['currentPhotos'][$i]) {
                        // Remove old product photo
                        $oldPhotoSrc = _DIR_ROOT . '/public/' . $updateData['removePhotos'][$j];
                        array_map('unlink', glob($oldPhotoSrc));

                        // Remove old thumb product photo
                        $oldThumbPhotoSrc = _DIR_ROOT . '/public/' . $updateData['removeThumbPhotos'][$j];
                        array_map('unlink', glob($oldThumbPhotoSrc));
                    }
                }
            }
        }

        // Use RegExr to get latest photo name
        $latestPhotoSrc = end($updateData['currentPhotos']);
        $regexLatestPhoto = "/\d+(?=\.)/i";
        $matches = array();
        $latestPhotoSrc = preg_match($regexLatestPhoto, $latestPhotoSrc, $matches);
        $latestPhotoName = $matches[0];

        // Add more product photos
        $photos = [];
        if ($_FILES['photos']['name'][0] != '') {
            $len = sizeof($_FILES['photos']['tmp_name']);
            for ($i = 0; $i < $len; ++$i) {
                $src = $this->uploadProductPhoto($_FILES['photos']['tmp_name'][$i], strval($i + (int)$latestPhotoName + 1), str_replace('image/', '', $_FILES['photos']['type'][$i]), $shopId, $updateData['code'], 80);
                array_push($photos, $src);
            }
        }

        $updateData['addPhotos'] = $photos; // update photos
        $remainPhotos = array();
        $remainPhotos = array_diff($updateData['currentPhotos'], $updateData['removePhotos']);
        $updateData['productPhotos'] = array_merge($remainPhotos, $updateData['addPhotos']); // productPhotos will be used to update in database

        // Update product in database
        $apiResProduct = ApiCaller::put(PRODUCT_SERVICE_API_URL . '/update-product', $updateData);
        if ($apiResProduct['statusCode'] === 200 || $apiResProduct['statusCode'] === 201) {
            $this->setViewContent('isError', false);
        } else {
            $this->setViewContent('isError', true);
        }

        // Update product detail  in database
        $apiResProductDetail = ApiCaller::put(PRODUCT_SERVICE_API_URL . '/update-product-detail', $updateData);
        if ($apiResProductDetail['statusCode'] === 200 || $apiResProductDetail['statusCode'] === 201) {
            $this->setViewContent('isError', false);
            $this->setSessionMessage('Cập nhật thành công', false);
            self::redirect('/kenh-ban-hang/san-pham/tat-ca');
        } else {;
            $this->setViewContent('isError', true);
            $this->setSessionMessage('Cập nhật thất bại', true);
            self::redirect('/kenh-ban-hang/san-pham/tat-ca');
        }
    }

    // Statistic
    public function overview()
    {
        global $shop;
        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/shop-statistic-overview/' . $shop->_get('shopId'));
        $stats = [
            'revenue' => 0,
            'order' => 0,
            'review' => 0,
            'product' => 0
        ];
        if ($apiRes['statusCode'] === 200) {
            $stats = (array) $apiRes['data'];
        }

        $this->setViewContent('stats', $stats);
        $this->setPageTitle('Tổng quan kinh doanh');
        $this->appendCssLink('shop/overview.css');
        $this->setContentViewPath('shop/overview');
        $this->render('layouts/shop', $this->data);
    }

    public function revenue()
    {
        global $shop;
        $this->setPassedVariables(['ORDER_SERVICE_API_URL' => ORDER_SERVICE_API_URL, 'SHOP_ID' => $shop->_get('shopId')]);
        $this->setPageTitle('Doanh thu');
        $this->appendJSLink(['shop/revenue.js']);
        $this->appendJsCDN('https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js');
        $this->setContentViewPath('shop/revenue');
        $this->render('layouts/shop');
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
