<?php
class Account extends Controller
{
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
            $conn = MySQLConnection::getConnect();
            $st = $conn->prepare('SELECT EXISTS(SELECT * FROM accounts WHERE email = :email)');
            $st->execute([':email' => $email]);
            $count = $st->fetchColumn();
            if ((int)$count >= 1) {
                $this->setViewContent('formError', 'Tài khoản đã tồn tại !');
                $this->renderSignupPage();
                return;
            }

            // hash password
            $hashPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => BCRYPT_SALT]);

            // create an account
            $sql = "INSERT INTO	accounts (email, password, createdAt, updatedAt) VALUES (?,?,?,?)";
            $now = date_create('now')->format('Y-m-d H:i:s');
            $isCreateAccountSuccess = $conn->prepare($sql)->execute([$email, $hashPwd, $now, $now]);

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

    // Private methods
    private function renderSignupPage()
    {
        $this->setContentViewPath('account/signup');
        $this->appendCssLink(['account/signup.css']);
        $this->appendJSLink(['account/signup.js']);
        $this->render('layouts/general', $this->data);
    }
}
