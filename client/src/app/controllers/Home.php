<?php
class Home extends Controller
{
    public function index()
    {
        $this->setViewContent('productData', []);
        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/homepage-products');

        if ($apiRes['statusCode'] === 200) {
            $this->setViewContent('productData', $apiRes['data']);
        }

        $this->setContentViewPath('home/index');
        $this->setPageTitle('Trang chủ');
        $this->appendCssLink(['home.css', 'product-card.css']);
        $this->appendJSLink(['utils/format.js', 'utils/product-mixin.js', 'utils/toast.js', 'home.js', 'scroll-top.js']);
        $this->setPassedVariables(['PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL, 'STATIC_FILE_URL' => STATIC_FILE_URL]);

        $this->render('layouts/general', $this->data);
    }

    public function shopInfo($shopId)
    {
        global $user;
        $shop = ShopModel::findShopById($shopId);
        $categoryApiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalog-name-by-id/' . $shop->_get('catalogId'));

        $shopInfo = [
            'accountId' => $shop->_get('accountId'),
            'shopId' => $shop->_get('shopId'),
            'phone' => $shop->_get('phone'),
            'name' => $shop->_get('name'),
            'foundingDate' => $shop->_get('foundingDate'),
            'supporterName' => $shop->_get('supporterName'),
            'catalogId' => $shop->_get('catalogId'),
            'openHours' => $shop->_get('openHours'),
            'logoUrl' => $shop->_get('logoUrl'),
            'isOnline' => $shop->_get('isOnline'),
            'createdAt' => $shop->_get('createdAt'),
            'category' => $categoryApiRes['data'],
        ];

        $productDocs = ApiCaller::get(PRODUCT_SERVICE_API_URL . "/list/by-shop?shopId=$shopId&pageSize=1000&page=1");
        $products = $productDocs['statusCode'] === 200 ? $productDocs['data']->docs : [];

        $this->setPageTitle('Thông tin cửa hàng');
        $this->setContentViewPath('shop-info');

        $this->setViewContent('shop', $shopInfo);
        $this->setViewContent('products', $products);

        $this->setPassedVariables([
            'SHOP_INFO' => json_encode($shopInfo), 'USER_ID' => json_encode($user->_get('userId')),
            'DEFAULT_SHOP_AVT' => DEFAULT_SHOP_AVT, 'STATIC_URL' => STATIC_FILE_URL,
            'SUPPORT_SERVICE_API_URL' => SUPPORT_SERVICE_API_URL,
            'CHAT_SOCKET_SERVER' => CHAT_SOCKET_SERVER
        ]);
        $this->appendCssLink(['product-card.css', 'chat-box.css', 'shop-info.css']);
        $this->appendJSLink(['chat-box.js', 'utils/format.js', 'chat-with-shop.js']);
        $this->appendJsCDN([STATIC_FILE_URL . '/vendors/socket.io.min.js']);

        $this->render('layouts/general', $this->data);
    }
}
