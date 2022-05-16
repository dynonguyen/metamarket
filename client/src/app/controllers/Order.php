<?php
class Order extends Controller
{
    public function info()
    {
        global $user;
        if (!empty($user->_get('userId'))) {
            $this->setPageTitle('Thông tin giao hàng');
            $this->setPassedVariables([
                'USER_SERVICE_API_URL' => USER_SERVICE_API_URL,
                'PRODUCT_SERVICE_API_URL' => PRODUCT_SERVICE_API_URL,
                'SHIPPING_FEE' => SHIPPING_FEE
            ]);
            $this->appendCssLink(['order/info.css']);
            $this->appendJSLink(['utils/address-select.js', 'utils/format.js', 'order/info.js']);
            $this->setContentViewPath('order/info');
            $this->render('layouts/general', $this->data);
        } else {
            self::redirect('/tai-khoan/dang-nhap');
        }
    }

    public function momoPaymentResult()
    {
        global $user;
        try {
            if (!empty($_GET)) {
                $orderCode = $_GET['orderId'];
                // Check order code, prevent user from reloading page
                $apiRes = ApiCaller::get(ORDER_SERVICE_API_URL . '/exist/by-order-code/' . $orderCode);
                if ($apiRes['data'] == 1) {
                    self::redirect('/');
                    return;
                }

                $resultCode = (int)$_GET['resultCode'];
                $amount = (int)$_GET['amount'];
                $transId = $_GET['transId'];
                $extraData = $_GET['extraData'];

                $extraDataArr = explode('&', $extraData);
                $receiverData = [];
                foreach ($extraDataArr as $item) {
                    $temp = explode('=', $item);
                    $receiverData = array_merge($receiverData, [$temp[0] => $temp[1]]);
                }

                $receiverName = $receiverData['receiverName'];
                $receiverPhone = $receiverData['receiverPhone'];
                $wardId = $receiverData['wardId'];
                $addrDetail = $receiverData['addrDetail'];
                $orderNote = $receiverData['orderNote'];
                $cart = json_decode($receiverData['cart']);
                $products = $this->addShopToProductList($cart);

                if ($resultCode == 0) {
                    // Create an order
                    $newOrder = ApiCaller::post(ORDER_SERVICE_API_URL . '/create', [
                        'userId' => $user->_get('userId'),
                        'orderCode' => $orderCode,
                        'receiverName' => $receiverName,
                        'receiverPhone' => $receiverPhone,
                        'isPayment' => true,
                        'wardId' => (int)$wardId,
                        'addrDetail' => $addrDetail,
                        'products' => $products,
                        'paymentMethod' => PAYMENT_METHOD['MOMO'],
                        'transportFee' => SHIPPING_FEE,
                        'orderTotal' => (int)$amount,
                        'note' => $orderNote,
                    ]);

                    if ($newOrder['statusCode'] === 200) {
                        $orderId = $newOrder['data'];
                        // Create a payment record in database
                        $newPayment = ApiCaller::post(PAYMENT_SERVICE_API_URL . '/user/create', [
                            'userId' => $user->_get('userId'),
                            'orderId' => str_replace("\"", "", $orderId),
                            'paymentType' => PAYMENT_METHOD['MOMO'],
                            'transactionCode' => $transId,
                            'totalMoney' => (int)$amount,
                            'note' => '',
                        ]);
                        if ($newPayment['statusCode'] === 200) {
                            // Increase product stock
                            $this->updateStockProducts($products);
                            $this->appendJSLink('order/payment-success.js');
                            $this->setViewContent('isError', 0);
                        } else {
                            $this->setViewContent('isError', 1);
                        }
                    }
                } else {
                    $this->setViewContent('isError', 1);
                    $this->setViewContent('errorMessage', $_GET['message']);
                }

                $this->setPageTitle('Kết quả thanh toán đơn hàng');
                $this->setContentViewPath('order/payment-result');
                $this->render('layouts/general', $this->data);
            } else {
                self::redirect('/');
            }
        } catch (Exception $ex) {
            error_log($ex);
            self::redirect('/');
        }
    }

    public function momoQRCode()
    {
        $this->momoPayment("captureWallet");
    }

    public function momoATM()
    {
        $this->momoPayment("payWithATM");
    }

    // Momo processing
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function momoPayment($paymentType = "payWithATM")
    {
        if (!empty($_POST)) {
            global $hostUrl;

            $endpoint = MOMO_ENDPOINT;
            $partnerCode = MOMO_PARTNER_CODE;
            $accessKey = MOMO_ACCESS_KEY;
            $secretKey = MOMO_SECRET_KEY;

            $orderId = time() . "";
            $orderInfo = "Thanh toán đơn hàng qua MoMo QR Code";
            $amount = (int)$_POST['cartTotal'] + SHIPPING_FEE;
            $redirectUrl = $hostUrl . '/ket-qua-thanh-toan';
            $ipnUrl = $hostUrl . '/ket-qua-thanh-toan';
            $extraData =
                'receiverName=' . $_POST['receiverName'] .
                '&receiverPhone=' . $_POST['receiverPhone'] .
                '&wardId=' . $_POST['wardId'] .
                '&addrDetail=' . $_POST['addrDetail'] .
                '&orderNote=' . $_POST['note'] .
                '&cart=' . $_POST['cart'];

            $requestId = time() . "";
            $requestType = $paymentType;
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "MetaMarket",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            header('Location: ' . $jsonResult['payUrl']);
        }
    }

    private function addShopToProductList($products)
    {
        $result = $products;
        $len = sizeof($products);
        for ($i = 0; $i < $len; ++$i) {
            $apiRes = ApiCaller::get(PRODUCT_SERVICE_API_URL . '/get-shop/' . $products[$i]->productId);
            $result[$i]->shopId = (int)$apiRes['data'];
        }
        return $result;
    }

    private function updateStockProducts($products)
    {
        foreach ($products as $product) {
            ApiCaller::put(PRODUCT_SERVICE_API_URL . '/desc-stock', [
                'productId' => $product->productId,
                'quantity' => (int)$product->quantity
            ]);
        }
    }
}
