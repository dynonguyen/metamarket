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

    public static function findAll($page = 1, $limit = DEFAULT_PAGE_SIZE, $status = NULL)
    {
        try {
            $offset = ($page - 1) * $limit;
            $conn = MySQLConnection::getConnect();
            $statusQuery = $status !== NULL ? "AND status = $status" : '';

            $queryStr = "SELECT s.shopId, s.phone, s.name, s.foundingDate,
                                s.supporterName, s.createdAt, s.openHours, a.email, a.status,
                                c.businessLicense, c.foodSafetyCertificate, a.accountId
                        FROM shops AS s, accounts AS a, contracts AS c
                        WHERE a.accountId = s.accountId AND c.shopId = s.shopId $statusQuery
                        LIMIT $offset, $limit";
            $query = $conn->query($queryStr);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $shops = $query->fetchAll();
            return $shops;
        } catch (Exception $ex) {
            error_log($ex);
            return [];
        }
    }

    public static function countAllShop($status = NULL)
    {
        try {
            $conn = MySQLConnection::getConnect();
            $statusQuery = $status !== NULL ? "AND status = $status" : '';
            $query = $conn->query("SELECT COUNT(*) FROM shops AS s, accounts AS a WHERE a.accountId = s.accountId $statusQuery");
            return $query->fetchColumn();
        } catch (Exception $ex) {
            error_log($ex);
            return 0;
        }
    }
}
