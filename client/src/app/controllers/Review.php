<?php
class Review extends Controller
{
    public function postReviewProduct()
    {
        if (!empty($_POST['productId'])) {
            global $isAuth, $user;

            if ($isAuth) {
                $fullname = $user->_get('fullname');
                $email = $user->_get('phone'); // contact info
            } else {
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
            }

            $productId = $_POST['productId'];
            $content = $_POST['content'];
            $rate = (int)$_POST['rate'];
            $isAnonymous = isset($_POST['isAnonymous']) ? true : false;

            $apiRes = ApiCaller::post(
                REVIEW_SERVICE_API_URL . '/add-product-comment',
                [
                    'productId' => $productId,
                    'content' => $content,
                    'rate' => $rate,
                    'isAnonymous' => $isAnonymous,
                    'fullname' => $fullname,
                    'email' => $email
                ]
            );

            if ($apiRes['statusCode'] === 200 || $apiRes['statusCode'] === 201) {
                self::setSessionMessage('Thêm bình luận thành công', false);
                self::redirect('/san-pham/' . $productId);
                return;
            }

            if ($apiRes['statusCode'] === 403) {
                self::setSessionMessage('Bạn đã bình luận cho sản phẩm này', true);
                self::redirect('/san-pham/' . $productId);
                return;
            }
        }

        self::setSessionMessage('Thêm bình luận thất bại. Thử lại !', true);
        self::redirect('/san-pham/' . $productId);
    }
}
