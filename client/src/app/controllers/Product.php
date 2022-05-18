<?php
class Product extends Controller
{
    public function index($productId)
    {
        global $user;

        if (empty($productId) || strlen($productId) !== 24) {
            self::renderErrorPage('404');
        }

        $apiRes = ApiCaller::get(AGGREGATE_SERVICE_API_URL . '/product-details/' . $productId);
        if ($apiRes['statusCode'] === 200) {
            if (!empty($_SESSION['message'])) {
                $this->showSessionMessage();
            }
            $data = $apiRes['data'];
            $productName = $data->product->name;
            $catalog = $data->product->catalogId->name;
            $catalogLink = $data->product->catalogId->link;

            $this->setViewContent('product', $data->product);
            $this->setViewContent('productDetail', $data->productDetail);
            $this->setViewContent('shop', $data->shop);
            $this->setViewContent('reviews', $data->reviews);
            $this->setViewContent('otherProducts', $data->otherProducts);
            $this->setViewContent('breadcrumbs', [
                ['link' => '/', 'name' => 'Trang chủ'],
                ['link' => "/catalog/$catalogLink", 'name' => $catalog],
                ['link' => '#', 'name' => $productName],
            ]);

            $this->setPassedVariables([
                'SHOP_INFO' => json_encode($data->shop), 'USER_ID' => json_encode($user->_get('userId')),
                'DEFAULT_SHOP_AVT' => DEFAULT_SHOP_AVT, 'STATIC_URL' => STATIC_FILE_URL,
                'SUPPORT_SERVICE_API_URL' => SUPPORT_SERVICE_API_URL,
                'CHAT_SOCKET_SERVER' => CHAT_SOCKET_SERVER
            ]);
            $this->setContentViewPath('product');
            $this->appendCssLink(['product.css', 'product-card.css', 'chat-box.css']);
            $this->appendJSLink(['utils/toast.js', 'product.js', 'chat-box.js', 'utils/format.js', 'chat-with-shop.js']);
            $this->appendJsCDN([STATIC_FILE_URL . '/vendors/socket.io.min.js']);
            $this->setPageTitle($productName);
            $this->render('layouts/general', $this->data);
        } else {
            error_log($apiRes['error']);
            self::renderErrorPage('404');
        }
    }

    public function search()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        if (empty($keyword)) {
            self::redirect('/');
        }

        $sort = empty($_GET['s']) ? '' : $_GET['s'];

        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/search?keyword=' . str_replace(' ', '%20', $keyword) . '&sort=' . $sort);

        $productDocs = null;
        if ($apiRes['statusCode'] === 200) {
            $productDocs = $apiRes['data'];
        }
        $this->setPassedVariables(['sort' => $sort, 'PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL, 'keyword' => $keyword]);

        $this->setViewContent('productDocs', $productDocs);
        $this->setViewContent('sort', $sort);

        $this->setContentViewPath('search-result');
        $this->appendCssLink(['product-card.css']);
        $this->appendJSLink(['utils/format.js', 'utils/product-mixin.js', 'utils/toast.js', 'search-result.js']);

        $this->setPageTitle("Tìm kiếm '$keyword'");
        $this->render('layouts/general', $this->data);
    }
}
