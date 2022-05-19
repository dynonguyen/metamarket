<?php
class AdminAccountModel
{
    use GetterSetter;

    private $adminId;
    private $username;
    private $password;
    private $fullname;
    private $peopleId;
    private $address;
    private $status;
    private $position;
    private $createdAt;
    private $updatedAt;

    public static function findAdminByUsername(string $username)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM adminAccounts WHERE username = '$username'");
            $query->setFetchMode(PDO::FETCH_CLASS, 'AdminAccountModel');
            $admin = $query->fetch();
            return $admin;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function isExistByUsername(string $username)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $st = $conn->prepare('SELECT EXISTS(SELECT * FROM adminAccounts WHERE username = :username)');
            $st->execute([':username' => $username]);
            $count = $st->fetchColumn();
            echo "<script>console.log('test login: " . $count . "' );</script>";
            return (int)$count >= 1;
        } catch (Exception $ex) {
            echo "<script>console.log('test login: " . $username . "' );</script>";
            error_log($ex);
            return false;
        }
    }

    public static function findAdminByAdminId($adminId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM adminAccounts WHERE adminId = $adminId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'AdminAccounts');
            $admin = $query->fetch();
            return $admin;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }
}
