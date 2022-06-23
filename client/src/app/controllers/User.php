<?php
require_once _DIR_ROOT . '/utils/Jwt.php';
require_once _DIR_ROOT . '/utils/Mail.php';
require_once _DIR_ROOT . '/app/models/Account.php';
require_once _DIR_ROOT . '/app/models/User.php';
require_once _DIR_ROOT . '/app/models/Shop.php';

class User extends Controller
{
    public function index()
    {
        global $isAuth;
        if ($isAuth) {
            $this->renderInfoPage();
        } else {
            self::redirect('/tai-khoan/dang-nhap', 301);
        }
    }

    public function postUpdateInfo()
    {
        ['name' => $name, 'phone' => $phone, 'gender' => $gender, 'dbo' => $dbo] = $_POST;

        if (empty($name) || empty($phone) || empty($gender) || empty($phone)) {
            $this->setViewContent('formError', 'Cập nhật thất bại !');
            $this->renderInfoPage();
            return;
        }

        global $user;
        // get user
        $userId = $user->_get('userId');

        $conn = MySQLConnection::getConnect();

        $sql = "UPDATE users
        SET phone = ?, fullname = ?, gender = ?, dbo = ?, createdAt = ?, updatedAt = ?
        WHERE userId = ?";

        $gender = ($gender == 'Nam') ? 1 : 0;

        $now = date_create('now')->format('Y-m-d H:i:s');

        $isUpdateInfoSuccess = $conn->prepare($sql)->execute([$phone, $name, $gender, $dbo, $now, $now, $userId]);

        if ((int)$isUpdateInfoSuccess === 1) {
            $this->setViewContent('formError', 'Cập nhật thành công !');
            // $this->renderInfoPage();
            self::redirect('/tai-khoan/thong-tin');
        } else {
            $this->setViewContent('formError', 'Cập nhật thất bại !');
            $this->renderInfoPage();
            throw new Exception("Cập nhật thất bại");
        }
    }

    private function renderInfoPage()
    {
        global $user;
        $this->setViewContent('user', $user);
        $this->setContentViewPath('user/info');
        $this->appendCssLink(['user/info.css']);
        $this->appendJSLink(['user/info.js']);
        $this->setPageTitle('Thông tin tài khoản');
        $this->render('layouts/general', $this->data);
    }
}
