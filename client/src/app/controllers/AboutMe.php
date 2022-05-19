<?php
class AboutMe extends Controller
{
    public function index()
    {
        $this->setPageTitle('Giới thiệu về MetaMarket');
        $this->setContentViewPath('about-me/index');
        $this->render('layouts/general', $this->data);
    }

    public function securityPolicy()
    {
        $this->setPageTitle('Chính sách bảo mật');
        $this->setContentViewPath('about-me/security-policy');
        $this->render('layouts/general', $this->data);
    }

    public function service()
    {
        $this->setPageTitle('Điều khoản và dịch vụ');
        $this->setContentViewPath('about-me/service');
        $this->render('layouts/general', $this->data);
    }

    public function customerSupport()
    {
        $this->setPageTitle('Điều khoản và dịch vụ');
        $this->setContentViewPath('about-me/customer-support');
        $this->render('layouts/general', $this->data);
    }

    public function shippingPolicy()
    {
        $this->setPageTitle('Chính sách giao hàng');
        $this->setContentViewPath('about-me/shipping-policy');
        $this->render('layouts/general', $this->data);
    }

    public function paymentPolicy()
    {
        $this->setPageTitle('Chính sách thanh toán');
        $this->setContentViewPath('about-me/payment-policy');
        $this->render('layouts/general', $this->data);
    }

    public function refundPolicy()
    {
        $this->setPageTitle('Chính sách đổi trả');
        $this->setContentViewPath('about-me/refund-policy');
        $this->render('layouts/general', $this->data);
    }

    public function discountPolicy()
    {
        $this->setPageTitle('Chính sách ưu đãi');
        $this->setContentViewPath('about-me/discount-policy');
        $this->render('layouts/general', $this->data);
    }
}
