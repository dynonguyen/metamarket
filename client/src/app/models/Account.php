<?php
class AccountModel
{
    use GetterSetter;

    private $accountId;
    private $email;
    private $password;
    private $googleId;
    private $status;
    private $createdAt;
    private $updatedAt;

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
}
