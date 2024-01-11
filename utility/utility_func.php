<?php
//check_user_role() return true if user is admin, false otherwise
function check_user_role($conn, $params, $source = "N/A", $redirect_error = "") : bool{

    $role = DB::get_record_by_field($conn,
        "SELECT role FROM Users WHERE id = ?",
        ["i"],
        $params,
        $source,
        $redirect_error)[0];

    if($role["role"] == 1){
        return true;
    }
    return false;
}

// Questa funzione ha lo scopo di estrarre le informazioni dell'utente che si decide di visualizzare
// dalla dashboard. Se nessun utente è stato selezionato vengono ritornate le info dell'utente collegato
function select_user($id) : array{
    if($id == null) {
        // Setto la variabile di sessione cosi se modifico il profilo da apposita sezione
        // ritono sul profilo e non nella table
        $_SESSION['redirection'] = "/f1_project/show_profile.php";
        $id = $_SESSION["id"];
    }

    // echo "\n\n--" . $current_id . "--\n\n";

    $conn = DB::connect();
    $element = DB::get_record_by_field($conn,
        "SELECT * FROM Users WHERE id = ?",
        ["i"],
        [$id],
        "\show_profile.php",
        "/f1_project/show_profile.php")[0];
    if (!$conn->close()) {
        error("500", "conn_close()", "\show_profile.php", "/f1_project/views/private/users/all.php");
        exit;
    }
    
    return $element;
}

/**
 * @throws Exception|\Exception
 */
function generate_random_string($length): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = "";
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[random_int(0, $characters_length - 1)];
    }
    return $random_string;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once ('PHPMailer/src/Exception.php');
require_once ('PHPMailer/src/PHPMailer.php');
require_once ('PHPMailer/src/SMTP.php');
/**
 * Send email method
 * @param array $recipients : recipients email address (e.g. ["pippo@topolino.com", "pluto@topolino.com"] OR [["email" => "a@a.c"], ["email" => "b@b.c"]])
 * @param string $subject : email subject
 * @param string $body : email body (it can be HTML)
 * @param array $bcc : optional parameter to specify BCC (e.g. ["pippo@topolino.com", "pluto@topolino.com"] OR [["email" => "a@a.c"], ["email" => "b@b.c"]])
 * @return void
 * @throws Exception
 *
 * Service provided by https://github.com/PHPMailer/PHPMailer
 */
function send_mail(array $recipients, string $subject, string $body, array $bcc = []): void {
    $ini = parse_ini_file("config/keys.ini");

    // 'true' needed to set exceptions
    $mail = new PHPMailer(true);
    $mail->isSMTP(); // "Send messages using SMTP"
    $mail->Host = $ini["smtp_host"];
    $mail->SMTPAuth = true; // Whether to use SMTP authentication
    $mail->Username = $ini["g_email"]; // GMAIL email
    $mail->Password = $ini["g_app_password"]; // GMAIL APP Password
    $mail->SMTPSecure = $ini["smtp_secure"];
    $mail->Port = $ini["smtp_port"];

    // I send email from $ini["g_email"] to addresses stored in $to.
    $mail->setFrom($ini["g_email"], $ini["g_name"]?? null);
    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient["email"]?? $recipient);
    }
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // TODO: (to verify) Options required to avoid "SMTP Error: Could not connect to SMTP host. Failed to connect to server"
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // BCC implemented in order to respect privacy
    foreach ($bcc as $recipient) {
        $mail->addBCC($recipient["email"]?? $recipient);
    }

    $mail->send();
}