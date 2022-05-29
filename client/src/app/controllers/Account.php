<?php
require_once _DIR_ROOT . '/utils/Jwt.php';
require_once _DIR_ROOT . '/utils/Mail.php';
require_once _DIR_ROOT . '/app/models/Account.php';
require_once _DIR_ROOT . '/app/models/User.php';
require_once _DIR_ROOT . '/app/models/Shop.php';

class Account extends Controller
{
    public function index()
    {
        self::redirect('/tai-khoan/dang-nhap', 301);
    }

    public function signup()
    {
        $this->renderSignupPage();
    }

    public function postSignup()
    {
        ['email' => $email, 'password' => $password, 'fullname' => $fullname] = $_POST;

        // validate data
        if (
            empty($email) || empty($password) || empty($fullname) ||
            strlen($email) > MAX_LEN_EMAIL || strlen($fullname) > MAX_LEN_FULLNAME || strlen($password) > MAX_LEN_PASSWORD
        ) {
            $this->setViewContent('formError', 'Dữ liệu không hợp lệ');
            $this->renderSignupPage();
            return;
        }

        try {
            // check if account existence
            $isExist = AccountModel::isExistByEmail($email);
            if ($isExist) {
                $this->setViewContent('formError', 'Tài khoản đã tồn tại !');
                $this->renderSignupPage();
                return;
            }

            // hash password
            $hashPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);

            // create an account
            $conn = MySQLConnection::getConnect();
            $sql = "INSERT INTO	accounts (email, password, type, createdAt, updatedAt, status) VALUES (?,?,?,?,?,?)";
            $now = date_create('now')->format('Y-m-d H:i:s');
            $isCreateAccountSuccess = $conn->prepare($sql)->execute([$email, $hashPwd, USER_ROLE, $now, $now, ACCOUNT_STATUS['ACTIVE']]);

            if ((int)$isCreateAccountSuccess === 1) {
                $accountId = $conn->lastInsertId();
                // Create an user
                $sql = "INSERT INTO	users (accountId, fullname, createdAt, updatedAt) VALUES (?,?,?,?)";
                $isUserSuccess = $conn->prepare($sql)->execute([$accountId, $fullname, $now, $now]);

                if ((int)$isUserSuccess === 1) {
                    echo "Đăng ký thành công";
                    self::redirect('/tai-khoan/dang-nhap');
                } else {
                    throw new Exception("Đăng ký thất bại");
                }
            } else {
                throw new Exception("Đăng ký thất bại");
            }
        } catch (Exception $ex) {
            $this->setViewContent('formError', 'Đã xảy ra lỗi. Đăng ký thất bại!');
            $this->renderSignupPage();
            error_log(strval($ex));
        }
    }

    public function login()
    {
        global $isAuth;
        if ($isAuth) {
            self::redirect('/');
        } else {
            $this->showSessionMessage();
            $this->renderLoginPage();
        }
    }

    public function postLogin()
    {
        ['email' => $email, 'password' => $password] = $_POST;

        if (empty($email) || empty($password)) {
            $this->setViewContent('formError', 'Đăng nhập thất bại !');
            $this->renderLoginPage();
            return;
        }

        // check if existence
        $isExist = AccountModel::isExistByEmail($email);
        if (!$isExist) {
            $this->setViewContent('formError', 'Tài khoản không tồn tại !');
            $this->renderLoginPage();
            return;
        }

        // verify password
        $account = AccountModel::findAccountByEmail($email);
        $accountPwd = $account->_get('password');
        $accountId = $account->_get('accountId');
        $status = $account->_get('status');

        $isCorrectPwd = password_verify($password, $accountPwd);
        if (!$isCorrectPwd) {
            $this->setViewContent('formError', 'Mật khẩu không chính xác !');
            $this->renderLoginPage();
            return;
        }

        if ($status == ACCOUNT_STATUS['WAITING_APPROVAL']) {
            $this->setViewContent('formError', 'Tài khoản của bạn đang chờ được xét duyệt, vui lòng thử lại sau !');
            $this->renderLoginPage();
            return;
        }
        if ($status == ACCOUNT_STATUS['LOCKED']) {
            $this->setViewContent('formError', 'Tài khoản của bạn đã bị khoá, vui lòng liên hệ chúng tôi để biết thêm thông tin');
            $this->renderLoginPage();
            return;
        }

        // get user
        $user = $account->_get('type') == USER_ROLE ? UserModel::findUserByAccountId($accountId) : ShopModel::findShopByAccountId($accountId);
        $userId =  $account->_get('type') == USER_ROLE ? $user->_get('userId') : $user->_get('shopId');

        // set cookie
        $this->onLoginSuccess($accountId, $userId, $account->_get('type'));
    }

    public function logout()
    {
        setcookie(COOKIE_LOGIN_KEY, "", time() - COOKIE_LOGIN_EXP, "/");
        $_SESSION['isAuth'] = false;
        unset($_SESSION['account']);
        self::redirect('/');
    }

    public function loginGoogle()
    {
        $client = $this->getGoogleAPIClient();

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            // Get profile
            $googleOAuth = new Google\Service\Oauth2($client);
            $accountInfo = $googleOAuth->userinfo->get();
            $email = $accountInfo->email;
            $name = $accountInfo->name;
            $googleId = $accountInfo->id;

            // Check account in database
            $isExist = AccountModel::isExistByEmail($email);
            if ($isExist) {
                $account = AccountModel::findAccountByEmail($email);
                $accountId = $account->_get('accountId');
                $user = UserModel::findUserByAccountId($accountId);
                $userId = $user->_get('userId');

                $this->onLoginSuccess($accountId, $userId, USER_ROLE);
            } else {
                // Create account & user
                $conn = MySQLConnection::getConnect();

                $sql = "INSERT INTO	accounts (email, googleId, type, createdAt, updatedAt, status) VALUES (?,?,?,?,?,?)";
                $now = date_create('now')->format('Y-m-d H:i:s');
                $isCreateAccountSuccess = $conn->prepare($sql)->execute([$email, $googleId, USER_ROLE, $now, $now, ACCOUNT_STATUS['ACTIVE']]);

                if ((int)$isCreateAccountSuccess === 1) {
                    $accountId = $conn->lastInsertId();
                    $sql = "INSERT INTO	users (accountId, fullname, createdAt, updatedAt) VALUES (?,?,?,?)";
                    $isUserSuccess = $conn->prepare($sql)->execute([$accountId, $name, $now, $now]);

                    if ((int)$isUserSuccess === 1) {
                        $userId = $conn->lastInsertId();
                        $this->onLoginSuccess($accountId, $userId, USER_ROLE);
                    } else {
                        throw new Exception("Đăng nhập thất bại");
                    }
                } else {
                    throw new Exception("Đăng nhập thất bại");
                }
            }
        }
    }

    public function forgotPassword()
    {
        if (!empty($_SESSION['message'])) {
            self::showSessionMessage();
        }

        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $isAccountExist = AccountModel::isExistByEmail($email);

            if (!$isAccountExist) {
                $this->setViewContent('error', 'Tài khoản không tồn tại !');
            } else {
                $isSendSuccess = MailUtil::sendForgetPassword($email);
                if ($isSendSuccess) {
                    $this->setViewContent('isSuccess', true);
                }
            }
        }
        $this->setPageTitle('Quên mật khẩu');
        $this->setContentViewPath('account/forgot-password');
        $this->render('layouts/general', $this->data);
    }

    public function changePassword()
    {
        if (!empty($_GET['code'])) {
            $code = $_GET['code'];
            $jwt = JwtUtil::decode($code);
            if ($jwt) {
                $email = $jwt['sub']->email;

                $this->setPageTitle('Thay đổi mật khẩu');
                $this->appendJSLink('account/change-password.js');
                $this->setViewContent('email', $email);
                $this->setViewContent('code', $code);
                $this->setContentViewPath('account/change-password');
                $this->render('layouts/general', $this->data);
                return;
            }
        }

        self::setSessionMessage('Liên kết đã hết hạn hoặc không hợp lệ. Vui lòng thử lại !', true);
        self::redirect('/quen-mat-khau');
    }

    public function postChangePassword()
    {
        if (!empty($_POST['code']) && !empty($_POST['password'])) {
            $code = $_POST['code'];
            $password = $_POST['password'];
            $jwt = JwtUtil::decode($code);

            if ($jwt) {
                $email = $jwt['sub']->email;
                $hashPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);
                $isSuccess = AccountModel::updatePasswordByEmail($email, $hashPwd);
                if ($isSuccess) {
                    self::setSessionMessage('Thay đổi mật khẩu thành công', false);
                    self::redirect('/tai-khoan/dang-nhap');
                }
            } else {
                self::setSessionMessage('Liên kết đã hết hạn hoặc không hợp lệ. Vui lòng thử lại !', true);
                self::redirect('/quen-mat-khau');
            }

            return;
        }
        self::setSessionMessage('Thay đổi mật khẩu không thành công ! Thử lại', true);
        self::redirect('/quen-mat-khau');
    }

    public function shopRegister()
    {
        $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/catalogs?select=_id%20name');
        $catalogs = $apiRes['statusCode'] === 200 ? $apiRes['data'] : [];

        $this->showSessionMessage();
        $this->setViewContent('catalogs', $catalogs);
        $this->appendJsCDN(['https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js']);
        $this->setPageTitle("Đăng ký bán hàng");
        $this->appendCssLink("shop-register.css");
        $this->appendJSLink(['account/shop-register.js']);
        $this->setContentViewPath('account/shop-register');
        $this->render('layouts/general', $this->data);
    }

    public function postShopRegister()
    {
        if (empty($_POST) || empty($_FILES)) {
            $this->setSessionMessage('Đăng ký thất bại', true);
            self::redirect('/dang-ky-ban-hang');
        }

        try {
            $isAccountExist = AccountModel::isExistByEmail($_POST['email']);
            if ($isAccountExist) {
                $this->setSessionMessage('Email đã dược sử dụng', true);
                self::redirect('/dang-ky-ban-hang');
            }

            $data = $_POST;
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);

            $apiRes = ApiCaller::post(USER_SERVICE_API_URL . '/account/create-shop', $data);
            if ($apiRes['statusCode'] === 200) {
                $shop = json_decode($apiRes['data']);
                $this->uploadShopPhoto($shop->shopId);

                $this->setSessionMessage('Đăng ký tài khoản thành công. Chúng tôi đang xét duyệt tài khoản của bạn');
                self::redirect('/dang-ky-ban-hang');
            }

            throw new Exception();
        } catch (Exception $ex) {
            error_log($ex);
            $this->setSessionMessage('Đăng ký thất bại', true);
            self::redirect('/dang-ky-ban-hang');
        }
    }

    // Private methods
    private function renderSignupPage()
    {
        $this->setContentViewPath('account/signup');
        $this->appendCssLink(['account.css']);
        $this->appendJSLink(['account/signup.js']);
        $this->setPageTitle('Đăng ký');
        $this->render('layouts/general', $this->data);
    }

    private function renderLoginPage()
    {

        $googleClient = $this->getGoogleAPIClient();

        $this->setViewContent('googleLoginLink', $googleClient->createAuthUrl());
        $this->setContentViewPath('account/login');
        $this->appendCssLink(['account.css']);
        $this->appendJSLink(['account/login.js']);
        $this->setPageTitle('Đăng nhập');
        $this->render('layouts/general', $this->data);
    }

    private function getGoogleAPIClient()
    {
        $client = new Google\Client();
        $client->setClientId(GOOGLE_API_ID);
        $client->setClientSecret(GOOGLE_API_SECRET);
        $client->setRedirectUri(GOOGLE_API_CALLBACK_URL);
        $client->addScope("email");
        $client->addScope("profile");
        return $client;
    }

    private function onLoginSuccess($accountId, $userId, $role = USER_ROLE)
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

    private function uploadShopPhoto($shopId)
    {
        ['logoUrl' => $logoUrl, 'businessLicense' => $businessLicense,  'foodSafetyCertificate' => $foodSafetyCertificate] = $_FILES;
        $uploadDir = _DIR_ROOT . "/public/upload/shop-$shopId";
        mkdir($uploadDir);

        $logoUrlDir = '';
        $businessLicenseDir = '';
        $foodSafetyCertificateDir = '';

        if (!empty($logoUrl['tmp_name'])) {
            $type = str_replace('image/', '', $logoUrl['type']);
            move_uploaded_file($logoUrl['tmp_name'], "$uploadDir/logo.$type");
            $logoUrlDir = "upload/shop-$shopId/logo.$type";
        }
        if (!empty($businessLicense['tmp_name'])) {
            $type = str_replace('image/', '', $businessLicense['type']);
            $businessLicenseDir = "/public/upload/shop-$shopId/businessLicense.$type";
            move_uploaded_file($businessLicense['tmp_name'], "$uploadDir/businessLicense.$type");
        }
        if (!empty($foodSafetyCertificate['tmp_name'])) {
            $type = str_replace('image/', '', $foodSafetyCertificate['type']);
            $foodSafetyCertificateDir = "/public/upload/shop-$shopId/foodSafetyCertificate.$type";
            move_uploaded_file($foodSafetyCertificate['tmp_name'], "$uploadDir/foodSafetyCertificate.$type");
        }

        AccountModel::updateShopPhoto($shopId, $logoUrlDir, $businessLicenseDir, $foodSafetyCertificateDir);
    }
}
