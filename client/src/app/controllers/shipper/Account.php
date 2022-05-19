<?php
require_once _DIR_ROOT . '/utils/Jwt.php';

class Account extends Controller
{
    public function index()
    {
        self::redirect('/van-chuyen/dang-nhap', 301);
    }


    public function login()
    {
        global $isAuth;
        if ($isAuth) {
            self::redirect('/');
        } else {
            $this->renderLoginPage();
        }
    }

    public function postLogin()
    {
        ['username' => $username, 'password' => $password] = $_POST;

        if (empty($username) || empty($password)) {
            $this->setViewContent('error', 'Đăng nhập thất bại !');
            $this->renderLoginPage();
            return;
        }

        // check if existence
        $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/shipper/by-username/' . $username);
        if ($apiRes['statusCode'] === 200 && $apiRes['data']) {
            if (password_verify($password, $apiRes['data']->password)) {
            } else {
                $this->setViewContent('error', 'Mật khẩu không chính xác !');
                $this->renderLoginPage();
                return;
            }
        } else {
            error_log($apiRes['error']);
            $this->setViewContent('error', 'Tài khoản không tồn tại !');
            $this->renderLoginPage();
            return;
        }
    }

    public function logout()
    {
        setcookie(COOKIE_LOGIN_KEY, "", time() - COOKIE_LOGIN_EXP, "/");
        self::redirect('/');
    }

    private function renderLoginPage()
    {
        $this->setContentViewPath('shipper/login');
        $this->appendCssLink(['shipper/login.css']);
        $this->appendJSLink(['shipper/login.js']);
        $this->setPageTitle('Shipper login');
        $this->render('layouts/shipper/login', $this->data);
    }

    // private function onLoginSuccess($adminId, $role = ADMIN_ROLE)
    // {
    //     global $isAuth;
    //     $isAuth = true;

    //     $jwt = JwtUtil::encode(['adminId' => $adminId, 'role' => $role], JWT_EXP);
    //     setcookie(COOKIE_LOGIN_KEY, $jwt, COOKIE_LOGIN_EXP, path: '/', httponly: true);
    //     self::redirect('/', 301);
    // }
}
