<?php
require_once _DIR_ROOT . '/utils/Jwt.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailUtil
{
    private static function getMailConnect($isDebug = false)
    {
        $mail  = new PHPMailer(true);

        if ($isDebug) $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = trim(MAIL_USERNAME);
        $mail->Password   = trim(MAIL_PASSWORD);
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->setFrom('metamarket@support.com', 'MetaMarket');

        return $mail;
    }

    public static function sendForgetPassword($email)
    {
        require_once _DIR_ROOT . '/app/views/mixins/mail/forgot-password.php';
        try {
            $link = self::generateForgotLink($email, MAIL_EXP);

            $mail = self::getMailConnect();
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Lấy lại mật khẩu';
            $mail->Body = renderForgotPwdMail($link, MAIL_EXP);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    private static function generateForgotLink($email, $expMinutes = 10)
    {
        $jwt = JwtUtil::encode(['email' => $email], $expMinutes * 60);
        $serverUrl = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, strpos($_SERVER["SERVER_PROTOCOL"], '/'))) . '://' . $_SERVER['HTTP_HOST'];
        return $serverUrl . "/thay-doi-mat-khau?code=$jwt";
    }
}
