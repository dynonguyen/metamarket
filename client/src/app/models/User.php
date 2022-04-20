<?php
class UserModel
{
    use GetterSetter;

    private $userId;
    private $accountId;
    private $phone;
    private $fullname;
    private $gender;
    private $dbo;
    private $createdAt;
    private $updatedAt;

    public static function findUserByAccountId($accountId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM users WHERE accountId = $accountId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
            $user = $query->fetch();
            return $user;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function findUserById($userId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM users WHERE userId = $userId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'UserModel');
            $user = $query->fetch();
            return $user;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }
}
