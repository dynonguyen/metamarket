<?php

require_once _DIR_ROOT . '/utils/Jwt.php';

/** 
 *
 * Phân tích URL thành controller, action và params
 *
 */

class App
{
    private $controller, $action, $params, $routes;

    function __construct()
    {
        global $routes;
        if (!empty($routes['default_controller'])) {
            $this->controller = $routes['default_controller'];
            unset($routes['default_controller']);
        }

        $this->action = 'index';
        $this->params = [];
        $this->routes = new Route();
        $this->handleUrl();
    }

    function getUrl()
    {
        return !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO']  : '/';
    }

    function handleUrl()
    {
        $url = $this->getUrl();

        // virtual route -> real route
        $url = $this->routes->handleRoute($url);

        // Tách url ra thành mảng
        $urlSplits = array_values(array_filter(explode('/', $url)));

        // Kiểm tra thư mục lồng nhau, tìm ra controller thực sự
        // Ex: admin/dashboard => controller = Dashboard
        $urlCheck = '';
        foreach ($urlSplits as $key => $u) {
            $urlCheck .= $u . '/';
            $fileCheck = rtrim($urlCheck, '/');
            $fileArr = explode('/', $fileCheck);
            $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
            $fileCheck = implode('/', $fileArr);

            // Remove folder from urlSplit
            if (!empty($urlSplits[$key - 1])) {
                unset($urlSplits[$key - 1]);
            }

            if (file_exists('app/controllers/' . $fileCheck . '.php')) {
                $urlCheck = $fileCheck;
                break;
            }
        }
        $urlSplits = array_values($urlSplits);

        // Detect controller
        if (!empty($urlSplits[0])) {
            $this->controller = ucfirst($urlSplits[0]);
        } else {
            // default controller
            $this->controller = ucfirst($this->controller);
        }

        // Check user & role
        $role = $this->getUser();

        // protect page
        $this->controller = Route::protectPage($this->controller, $role);


        if (!$this->controller) {
            $this->handleError('404');
        }

        // Trường hợp trang chủ thì urlCheck = ''
        if (empty($urlCheck)) {
            $urlCheck = $this->controller;
        }

        if (file_exists('app/controllers/' . $urlCheck . '.php')) {
            require_once 'controllers/' . $urlCheck . '.php';
            if (class_exists($this->controller)) {
                $this->controller = new $this->controller();
            } else {
                $this->handleError('404');
            }

            // delete controller from urls
            unset($urlSplits[0]);
        } else {
            $this->handleError('404');
        }

        // Detect action
        if (!empty($urlSplits[1])) {
            $this->action = $urlSplits[1];
            unset($urlSplits[1]);
        }

        // Detect params & Pass params to Controller
        $this->params = array_values($urlSplits);

        // check the existence of action method
        if (method_exists($this->controller, $this->action)) {
            call_user_func_array([$this->controller, $this->action], $this->params);
        } else {
            $this->handleError('404');
        }
    }

    function handleError($name = '404')
    {
        require_once 'errors/' . $name . '.php';
    }

    private function getUser()
    {
        if (!empty($_SESSION['isAuth'])) {
            $account = $_SESSION['account'];
            $this->getGlobalUserWithRole($account['role'], $account['userId']);
            return $account['role'];
        }

        if (isset($_COOKIE[COOKIE_LOGIN_KEY])) {
            $accessToken = $_COOKIE[COOKIE_LOGIN_KEY];
            $jwtDecoded = JwtUtil::decode($accessToken);

            if (!empty($jwtDecoded)) {
                $userId = $jwtDecoded['sub']->userId;
                $role = $jwtDecoded['sub']->role;
                $this->getGlobalUserWithRole($role, $userId);
                return $role;
            }
        }

        return GUEST_ROLE;
    }

    private function getGlobalUserWithRole($role, $userId)
    {
        global $user, $shop, $shipper, $isAuth;

        if ($role === USER_ROLE) {
            $user = UserModel::findUserById($userId);
            if ($user->_get('userId')) {
                $isAuth = true;
            }
        } else if ($role === SHOP_ROLE) {
            $shop = ShopModel::findShopById($userId);
            if ($shop->_get('shopId')) {
                $isAuth = true;
            }
        } else if ($role === ADMIN_ROLE) {
            $admin = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/admin/by-id/' . $userId);

            if (!empty($admin['data']->accountId)) {
                $isAuth = true;
            }
        } else if ($role === SHIPPER_ROLE) {
            $shipper = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/shipper/by-id/' . $userId);

            if (!empty($shipper['data']->shipperId)) {
                $isAuth = true;
            }
        } else {
            $isAuth = false;
        }
    }
}
