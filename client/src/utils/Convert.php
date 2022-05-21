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
}
