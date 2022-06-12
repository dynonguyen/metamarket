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

        $this->setPageTitle('Thông tin cửa hàng');
        $this->setContentViewPath('shop-info');
        $this->setPassedVariables([
            'SHOP_INFO' => json_encode([]), 'USER_ID' => json_encode($user->_get('userId')),
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
