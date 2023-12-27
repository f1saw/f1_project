<?php
//check_user_role() return true if user is admin, false otherwise
function check_user_role($conn, $params, $source = "N/A", $redirect_error = "") : bool{

    $role = DB::get_record_by_field($conn,
        "SELECT role FROM Users WHERE id = ?",
        ["i"],
        $params,
        $source,
        $redirect_error)[0];

    if (!$conn->close()) {
        error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/table_users.php");
        exit;
    }

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
        $_SESSION['redirection'] = "/f1_project/views/private/user_detail.php";
        $current_id = $_SESSION["id"];
    }

    if(!isset($current_id)) {
        $conn = DB::connect();
        $element = DB::get_record_by_field($conn,
            "SELECT * FROM Users WHERE id = ?",
            ["i"],
            [$id],
            "user_detail.php",
            "/f1_project/views/private/user_detail.php")[0];
        if (!$conn->close()) {
            error("500", "conn_close()", "user_detail.php", "/f1_project/views/private/table_users.php");
            exit;
        }
    }
    else{
        $element = [];

        $element["id"]            = $_SESSION["id"];
        $element["first_name"]    = $_SESSION["first_name"];
        $element["last_name"]     = $_SESSION["last_name"];
        $element["email"]         = $_SESSION["email"];
        $element["date_of_birth"] = $_SESSION["date_of_birth"];
        $element["cookie_id"]     = $_SESSION["cookie_id"];
        $element["img_url"]       = $_SESSION["img_url"];
    }
    return $element;
}


use PHPMailer\PHPMailer\PHPMailer;
// $BCC must be an associative array with email field
function send_mail($destination_address, $subject, $body, $BCC = null){
    $ini = parse_ini_file("config/keys.ini");

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
    $mail->addAddress($destination_address);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $_SESSION["confirm_email"] = false;

    if($BCC != null){
        foreach ($BCC as $receiver) {
            $mail->addBCC($receiver["email"]);
        }
    }

    $mail->send();
}
