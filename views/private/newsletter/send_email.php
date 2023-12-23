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

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    if (isset($_POST["subject"]) && $_POST["subject"] && isset($_POST["text"]) && $_POST["text"]) {

        $subject = preg_replace('!\s+!', '', $_POST["subject"]);
        $body = preg_replace('!\s+!', '', $_POST["text"]);

        if (!$subject  || !$body) {
            error("500", "Fields NOT provided", "send_email.php", "/f1_project/views/private/newsletter/newsletter.php");
            exit;
        }

        $subject = htmlentities($_POST["subject"]);
        $body = htmlentities($_POST["text"]);

        $conn = DB::connect("send_email.php", "/f1_project/views/private/newsletter/send_email.php");
        [$num_users, $receivers_list] = DB::stmt_get_record_by_field($conn,
            "SELECT email FROM users WHERE newsletter = 1;",
        "send_email.php",
        "/f1_project/views/private/newsletter/send_email.php");
        if (!$conn->close()) {
            error("500", "conn_close()", "send_email.php", "/f1_project/views/private/newsletter/send_email.php");
            exit;
        }

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

            // I send email from $ini["g_email"] to itself.
            // The receivers will be pushed in the BCC in order to respect their privacy
            $mail->setFrom($ini["g_email"]);
            $mail->addAddress($ini["g_email"]);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            foreach ($receivers_list as $receiver) {
                $mail->addBCC($receiver["email"]);
            }

            $mail->send();

            $_SESSION["success"] = 1;
            $_SESSION["success_msg"] = "Email SENT successfully :)";
            header("Location: /f1_project/views/private/newsletter/newsletter.php");
            exit;

        } catch (Exception $e) {
            error("500", "PHPMailer exception: $e", "send_email.php", "/f1_project/views/private/newsletter/newsletter.php");
            exit;
        }
    } else {
        error("500", "Fields NOT provided", "send_email.php", "/f1_project/views/private/newsletter/newsletter.php");
        exit;
    }
} else {
    error("401", "Unauthorized access", "send_email.php", "/f1_project/views/public/login_form.php");
    exit;
}