<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

use PHPMailer\PHPMailer\Exception;

require_once ('PHPMailer/src/Exception.php');
require_once ('PHPMailer/src/PHPMailer.php');
require_once ('PHPMailer/src/SMTP.php');

// TODO: conferma registrazione via mail
// TODO: sistemare parametri error


require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("auth/auth.php");
require_once ("utility/utility_func.php");


if (session_status() == PHP_SESSION_NONE) session_start();

// TODO: bloccare pagina in caso di utente già registrato

/* -- ERROR | fields NOT set -- */
if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"])) {

    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $date_of_birth = $_POST["date_of_birth"] ?? "";
    $newsletter = isset($_POST["newsletter"]) ? 1 : 0;


    $first_name = preg_replace('!\s+!', '', $first_name);
    $last_name = preg_replace('!\s+!', '', $last_name);
    $email = preg_replace('!\s+!', '', $email);
    $date_of_birth = preg_replace('!\s+!', ' ', $date_of_birth);
    $password = trim($password);
    $password_confirm = trim($password_confirm);


    /* -- ERROR | Empty input fields -- */
    if ($first_name == "" || $first_name == " "
        || $last_name == "" || $last_name == " "
        || $email == "" || $email == " "
        || $password == ""
        || $password_confirm == ""
        /*|| $date_of_birth == "" || $date_of_birth == " "*/) {
        error("-1", "Empty input fields.", "registration.php", "/f1_project/views/public/registration_form.php");
        exit;
    }


    // REGEX EMAIL
    /* https://en.wikipedia.org/wiki/Email_address */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error("-1", "EMAIL pattern NOT valid.", "registration.php", "/f1_project/views/public/registration_form.php");
        exit;
    }


    // REGEX DATE OF BIRTH dd/mm/yyyy
    if ($date_of_birth && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
        error("-1", "Date of birth pattern NOT valid.", "registration.php", "/f1_project/views/public/registration_form.php");
        exit;
    }

    /* -- ERROR | passwords (mis)matching -- */
    if ($password != $password_confirm) {
        error("-1", "Mismatched passwords.", "registration.php", "/f1_project/views/public/registration_form.php");
        exit;
    }
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $subject = "Confirm email";
        $body = '
                    <!DOCTYPE html>
                    <html lang="en">
                    
                    <head>
                        <title>Confirm email</title>
                        <meta charset="UTF-8">
                    </head>
                    <body>
                    <p>Hi, we have received your request to register on our site. Please confirm your email to complete registration: <a href="http://localhost:63342/DB.php/auth/confirm_email.php">confirm email</p>
                    </body>
                    ';
        send_mail($email, $subject, $body);

        // I need to temporarily keep the recording values in memory
        $_SESSION["tmp_fname"] = $first_name;
        $_SESSION["tmp_lname"] = $last_name;
        $_SESSION["tmp_email"] = $email;
        $_SESSION["tmp_date_of_birth"] = $date_of_birth;
        $_SESSION["tmp_pass"] = $password;
        $_SESSION["tmp_cpass"] = $password_confirm;
        $_SESSION["tmp_hpass"] = $hash_password;
        $_SESSION["tmp_news"] = $newsletter;

        header("location: /f1_project/views/public/registration_form.php");

    } catch (Exception $e) {
        error("500", "PHPMailer exception: $e", "send_email.php", "/f1_project/views/private/newsletter/newsletter.php");
        exit;
    }

} else {
    error("-1", "Input fields NOT provided.", "registration.php", "/f1_project/views/public/registration_form.php");
    exit;
}
