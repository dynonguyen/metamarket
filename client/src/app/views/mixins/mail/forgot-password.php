<?php
function renderForgotPwdMail($link = '', $exp = 10)
{
    return "<div style='max-width: 776px; margin: 0 auto; background-color: #fff; padding: 12px'>
        <h2 style='text-transform: capitalize; color: #11254b; font-size: 22px'>MetaMarket Xin chào quý khách !</h2>

        <p style='font-size: 18px; color: #777;'>
            Bạn quên mật khẩu, đừng quá lo lắng ! Chúng tôi sẽ giúp bạn lấy lại một mật khẩu mới trong ít phút. <br> <br>
            Nếu bạn không thực hiện yêu cầu trên, hãy bỏ qua Email này. Hoặc liên hệ chúng tôi để nếu cảm thấy lo lắng.
        </p>

        <div style='text-align: center; margin: 24px 0;'>
            <a href='$link' target='_blank'>
                <button style='padding: 12px 18px; font-size: 16px; border:none; border-radius: 8px;background-color: #11254b;color:#fff'>Click vào đây để Reset mật khẩu</button>
            </a>
        </div>
        
        <p style='font-size: 18px; color: #f73131;'>Chú ý: Liên kết chỉ có hiệu lực trong $exp phút. Xin vui lòng không gửi liên kết này cho bất kỳ ai.</p>

        <p style='font-size: 18px; color: #777;'>Trân trọng,<br>MetaMarket Team</p>

        <hr>

        <p style='font-size: 15px; color: #777;'>Nếu bạn không thể Click vào nút trên, bạn có thể sao chép liên kết sau và dán vào trình duyệt <a href='$link' style='color: #3097d1' target='_blank'>$link</a> .</p>
    </div>";
}
