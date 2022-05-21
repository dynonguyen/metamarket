<?php
require_once _DIR_ROOT . '/utils/Jwt.php';

class InternalAccount extends Controller
{
    public function index()
    {
        self::redirect('/nhan-vien/dang-nhap', 301);
    }

    public function login($empType = 'admin')
    {
        global $isAuth;

        if ($isAuth) {
            self::redirect('/');
        } else {
            $this->renderLoginPage($empType);
        }
    }

    public function postLogin($empType)
    {
        ['username' => $username, 'password' => $password] = $_POST;

        if (empty($username) || empty($password)) {
            $this->setViewContent('error', 'Đăng nhập thất bại !');
            $this->renderLoginPage($empType);
            return;
        }

        // check if existence
        if ($empType === 'admin') {
            $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/admin/by-username/' . $username);
        } else {
            $apiRes = ApiCaller::get(INTERNAL_SERVICE_API_URL . '/shipper/by-username/' . $username);
        }

        if ($apiRes['statusCode'] === 200 && $apiRes['data']) {
            if (password_verify($password, $apiRes['data']->password)) {
            } else {
                $this->setViewContent('error', 'Mật khẩu không chính xác !');
                $this->renderLoginPage($empType);
                return;
            }
        } else {
            error_log($apiRes['error']);
            $this->setViewContent('error', 'Tài khoản không tồn tại !');
            $this->renderLoginPage($empType);
            return;
        }

        $accountId = $empType === 'admin' ? $apiRes['data']->accountId : $apiRes['data']->shipperId;

        // set cookie
        $role = $empType === 'admin' ? ADMIN_ROLE : SHIPPER_ROLE;
        $this->onLoginSuccess($accountId, $accountId, $role);
    }

    public function logout()
    {
        setcookie(COOKIE_LOGIN_KEY, "", time() - COOKIE_LOGIN_EXP, "/");
        $_SESSION['isAuth'] = false;
        unset($_SESSION['account']);
        self::redirect('/');
    }

    private function renderLoginPage($empType)
    {
        $this->setViewContent('empType', $empType);
        $this->setContentViewPath('internal-login');
        $this->appendCssLink(['account.css']);
        $this->appendJSLink(['internal-login.js']);
        $this->setPageTitle('Nhân viên đăng nhập');
        $this->render('layouts/general', $this->data);
    }

    private function onLoginSuccess($accountId, $userId, $role = ADMIN_ROLE)
    {
        global $isAuth;
        $isAuth = true;

        $jwt = JwtUtil::encode(['accountId' => $accountId, 'userId' => $userId, 'role' => $role], JWT_EXP);

        // Set session
        $_SESSION['isAuth'] = true;
        $_SESSION['account'] = ['accountId' => $accountId, 'userId' => $userId, 'role' => $role];

        // Set cookie
        setcookie(COOKIE_LOGIN_KEY, $jwt, COOKIE_LOGIN_EXP, path: '/', httponly: true);
        self::redirect('/', 301);
    }
}
