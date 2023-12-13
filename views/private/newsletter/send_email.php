<?php require_once("../../../auth/auth.php"); ?>
<?php require_once("../../../utility/error_handling.php"); ?>
<?php require_once ("../../../DB/DB.php"); ?>

<?php
[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);
    if (isset($_POST["subject"]) && isset($_POST["text"])){
        $conn = DB::connect();
        [$num_users, $to] = DB::stmt_get_record_by_field($conn,
            "SELECT email FROM users WHERE newsletter = 1;");
        if (!$conn->close()) {
            error("500", "conn_close()", "login.php", "/f1_project/views/public/login_form.php");
            exit;
        }
        $i = 1;
        $to_str = $to[0]["email"];
        for (; $i < $num_users; ++$i){
            $to_str .= ", ".$to[$i]["email"];
        }

        $subject = $_POST["subject"];
        $message = $_POST["text"];
        $headers = "From: f1@gmail.com"."\r\n"."Bcc: $to_str"."\r\n";

        if (mail($to_str, $subject, $message, $headers)) {
            echo "Your email was sent!";
        } else {
            echo "Error sending email.";
        }
    }
} else {
    error("401", "Email and pwd NOT correct", "login.php", "/f1_project/views/public/login_form.php");
    exit;
}