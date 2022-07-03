<?php
class ConvertUtil
{
    public static function orderStatusToString($status)
    {
        switch ((int)$status) {
            case ORDER_STATUS['PROCESSING']:
                return 'Đang xử lý';
            case ORDER_STATUS['PENDING_PAYMENT']:
                return 'Đang chờ thanh toán';
            case ORDER_STATUS['PENDING_SHOP']:
                return 'Chờ cửa hàng xử lý';
            case ORDER_STATUS['SHIPPING']:
                return 'Đang giao hàng';
            case ORDER_STATUS['COMPLETE']:
                return 'Hoàn tất đơn hàng';
            case ORDER_STATUS['CANCEL']:
                return 'Đơn hàng bị huỷ';
            default:
                return 'Đang xử lý';
        }
    }

    public static function accountStatusToString($status)
    {
        switch ((int)$status) {
            case ACCOUNT_STATUS['LOCKED']:
                return 'Đã khoá';
            case ACCOUNT_STATUS['ACTIVE']:
                return 'Đang hoạt động';
            case ACCOUNT_STATUS['WAITING_APPROVAL']:
                return 'Chờ xét duyệt';
            default:
                return '_';
        }
    }
}
