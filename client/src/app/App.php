<?php

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
}
