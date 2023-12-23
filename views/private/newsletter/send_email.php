<?php
/** Service provided by https://github.com/PHPMailer/PHPMailer */

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");


$ini = parse_ini_file("config/keys.ini");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
error("500", "set_include_path()");

require_once("auth/auth.php");
require_once("utility/error_handling.php");
require_once ("DB/DB.php");

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    if (isset($_POST["subject"]) && isset($_POST["text"])){
        $conn = DB::connect("send_email.php", "/f1_project/views/private/newsletter/send_email.php");
        [$num_users, $receivers_list] = DB::stmt_get_record_by_field($conn,
            "SELECT email FROM users WHERE newsletter = 1;",
        "send_email.php",
        "/f1_project/views/private/newsletter/send_email.php");
        if (!$conn->close()) {
            error("500", "conn_close()", "send_email.php", "/f1_project/views/private/newsletter/send_email.php");
            exit;
        }


        /*$i = 1;
        $to_str = $receivers_list[0]["email"];
        for (; $i < $num_users; ++$i){
            $to_str .= ", ".$receivers_list[$i]["email"];
        }

        $subject = $_POST["subject"];
        $message = $_POST["text"];
        $headers = "From: f1@gmail.com"."\r\n"."Bcc: $to_str"."\r\n";
        */

        /*
        if (mail($to, $subject, $message, $headers)) {
            echo "Your email was sent!";
        } else {
            echo error_get_last()['message'];
            echo "<br>" . print_r(error_get_last(), true);
            echo "Error sending email.";
        } */



        try {
            // 'true' needed to set exceptions
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = $ini["g_email"];
            $mail->Password = $ini["g_app_password"]; // GMAIL APP Password
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;

            $mail->setFrom($ini["g_email"]);
            $mail->addAddress("mat.nac2002@icloud.com");
            $mail->isHTML(true);
            $mail->Subject = "CIAO";
            $mail->Body = "<strong>Halo</strong>";
            $mail->send();

            echo "Mail SENT";

        } catch (Exception $e) {
            echo "Exception thrown:<br>$e";
        }







    }
} else {
    error("401", "Email and pwd NOT correct", "login.php", "/f1_project/views/public/login_form.php");
    exit;
}