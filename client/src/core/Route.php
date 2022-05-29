<?php
class Route
{
    public function handleRoute($url = '')
    {
        global $routes;
        $url = trim($url, '/');

        $handleUrl = $url;
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                if (preg_match('~' . $key . '~is', $url)) {
                    $handleUrl = preg_replace('~' . $key . '~is', $value, $url);
                }
            }
        }

        return $handleUrl;
    }

    public static function protectPage($controller, $role = USER_ROLE)
    {
        $commonControllers = ['account'];
        $c = strtolower($controller);

        if (in_array($c, $commonControllers)) return $controller;

        if ($role === SHOP_ROLE) return 'Shop';
        if ($role === ADMIN_ROLE) return 'Admin';
        //if ($role === SHIPPER_ROLE) return 'Shipper';

        // guest & user role
        //if ($c === 'shop' || $c === 'admin' || $c === 'shipper') {
            //return false;
        //}
        return $controller;
    }
}
