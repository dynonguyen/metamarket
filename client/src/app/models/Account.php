<?php
class AccountModel
{
    use GetterSetter;

    private $accountId;
    private $email;
    private $password;
    private $googleId;
    private $status;
    private $role;
    private $createdAt;
    private $updatedAt;

    public static function findEmailByAccountId(int|string $accountId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT email FROM accounts WHERE accountId = '$accountId'");
            $email = $query->fetchColumn(0);
            return $email;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function findAccountByEmail(string $email)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM accounts WHERE email = '$email'");
            $query->setFetchMode(PDO::FETCH_CLASS, 'AccountModel');
            $account = $query->fetch();
            return $account;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function isExistByEmail(string $email)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $st = $conn->prepare('SELECT EXISTS(SELECT * FROM accounts WHERE email = :email)');
            $st->execute([':email' => $email]);
            $count = $st->fetchColumn();
            return (int)$count >= 1;
        } catch (Exception $ex) {
            error_log($ex);
            return false;
        }
    }

    public static function updatePasswordByEmail(string $email, string $newPassword)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $st = $conn->prepare('UPDATE accounts SET password = :password WHERE email = :email');
            $st->execute([':email' => $email, 'password' => $newPassword]);
            $affectedRows = $st->rowCount();

            if ($affectedRows > 0) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            error_log($ex);
            return false;
        }
    }

    public static function updateShopPhoto(string $shopId, string $logoUrl, string $businessLicense, string $foodSafetyCertificate)
    {
        $conn = MySQLConnection::getConnect();
        $st = $conn->prepare("UPDATE contracts SET businessLicense = '$businessLicense', foodSafetyCertificate = '$foodSafetyCertificate' WHERE shopId = $shopId");
        $st->execute();

        $st = $conn->prepare("UPDATE shops SET logoUrl = '$logoUrl' WHERE shopId = $shopId");
        $st->execute();
    }
}
