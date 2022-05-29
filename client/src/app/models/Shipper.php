<?php
class ShipperModel
{
    use GetterSetter;

    private $shipperId;
    private $username;
    private $password;
    private $peopleId;
    private $address;
    private $driverLicense;
    private $status;
    private $createdAt;
    private $updatedAt;

    public static function findShipperByUsername(string $username)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM shippers WHERE username = '$username'");
            $query->setFetchMode(PDO::FETCH_CLASS, 'ShipperModel');
            $shipper = $query->fetch();
            return $shipper;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function isExistByUsername(string $username)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $st = $conn->prepare('SELECT EXISTS(SELECT * FROM shippers WHERE username = :username)');
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

    public static function findShipperByShipperId($shipperId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM shippers WHERE shipperId = $shipperId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'ShipperModel');
            $shipper = $query->fetch();
            return $shipper;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }
}
