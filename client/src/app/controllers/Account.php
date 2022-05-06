<?php
require_once _DIR_ROOT . '/utils/Jwt.php';
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
            $sql = "INSERT INTO	accounts (email, password, type, createdAt, updatedAt) VALUES (?,?,?,?,?)";
            $now = date_create('now')->format('Y-m-d H:i:s');
            $isCreateAccountSuccess = $conn->prepare($sql)->execute([$email, $hashPwd, USER_ROLE, $now, $now]);

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

        $isCorrectPwd = password_verify($password, $accountPwd);
        if (!$isCorrectPwd) {
            $this->setViewContent('formError', 'Mật khẩu không chính xác !');
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

                $sql = "INSERT INTO	accounts (email, googleId, type, createdAt, updatedAt) VALUES (?,?,?,?,?)";
                $now = date_create('now')->format('Y-m-d H:i:s');
                $isCreateAccountSuccess = $conn->prepare($sql)->execute([$email, $googleId, USER_ROLE, $now, $now]);

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
        setcookie(COOKIE_LOGIN_KEY, $jwt, COOKIE_LOGIN_EXP, path: '/', httponly: true);
        self::redirect('/', 301);
    }
}
