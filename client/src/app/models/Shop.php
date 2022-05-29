<?php
class ShopModel
{
    use GetterSetter;

    private $accountId;
    private $shopId;
    private $phone;
    private $name;
    private $foundingDate;
    private $supporterName;
    private $catalogId;
    private $openHours;
    private $logoUrl;
    private $isOnline;

    public static function findShopByAccountId($accountId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM shops WHERE accountId = $accountId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'ShopModel');
            $shop = $query->fetch();
            return $shop;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function findShopById($shopId)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $query = $conn->query("SELECT * FROM shops WHERE shopId = $shopId");
            $query->setFetchMode(PDO::FETCH_CLASS, 'ShopModel');
            $shop = $query->fetch();
            return $shop;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }

    public static function updateShop($shopId, $data)
    {
        try {
            [
                'name' => $name,
                'phone' => $phone,
                'supporterName' => $supporterName,
                'openHours' => $openHours,
                'logoUrl' => $logoUrl
            ] = $data;
            $conn = MySQLConnection::getConnect();
            $query = "UPDATE shops 
                    SET name = '$name', phone = '$phone', supporterName = '$supporterName', openHours = '$openHours', logoUrl = '$logoUrl'
                    WHERE shopId = $shopId";
            $st = $conn->prepare($query);
            return $st->execute();
        } catch (Exception $ex) {
            error_log($ex);
            return false;
        }
    }
}
