<?php
/** Service provided by https://github.com/PHPMailer/PHPMailer */

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

$ini = parse_ini_file("config/keys.ini");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ('PHPMailer/src/Exception.php');
require_once ('PHPMailer/src/PHPMailer.php');
require_once ('PHPMailer/src/SMTP.php');

require_once ("auth/auth.php");
require_once ("utility/error_handling.php");
require_once ("DB/DB.php");

/**
 * @param array $to: receiver email address
 * @param string $subject: email subject
 * @param string $body: email body (it can be HTML)
 * @param array $bcc: optional parameter to specify BCC
 * @return void
 */
function send_mail(array $to, string $subject, string $body, array $bcc = []): void {
    global $ini;
    [$login_allowed, $user] = check_cookie();
    if (check_admin_auth($user)) {
        set_session($user);

        try {
            // 'true' needed to set exceptions
            $mail = new PHPMailer(true);
            $mail->isSMTP(); // "Send messages using SMTP"
            $mail->Host = $ini["smtp_host"];
            $mail->SMTPAuth = true; // Whether to use SMTP authentication
            $mail->Username = $ini["g_email"]; // GMAIL email
            $mail->Password = $ini["g_app_password"]; // GMAIL APP Password
            $mail->SMTPSecure = $ini["smtp_secure"];
            $mail->Port = $ini["smtp_port"];

            // I send email from $ini["g_email"] to address stored in $to.
            $mail->setFrom($ini["g_email"]);
            foreach ($to as $receiver) {
                $mail->addAddress($receiver);
            }
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // BCC implemented in order to respect privacy
            foreach ($bcc as $receiver) {
                $mail->addBCC($receiver);
            }

            $mail->send();

        } catch (Exception $e) {
            error("500", "PHPMailer exception: $e", "send_email.php", "/f1_project/views/private/newsletter/newsletter.php");
            exit;
        }
    }
}