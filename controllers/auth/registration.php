<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("controllers/auth/auth.php");

[$login_allowed, $user] = check_cookie();
if ($login_allowed) {
    error("-1", "Already registered.", "\controllers\auth\\registration.php", "/f1_project/views/private/dashboard.php");
    exit;
}

// TODO: sistemare parametri error
// TODO: bloccare pagina in caso di utente già registrato

/* -- ERROR | fields NOT set -- */
if (isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"]) /* && isset($_POST["date_of_birth"])*/) {

    $first_name = $_POST["fname"];
    $last_name = $_POST["lname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $date_of_birth = $_POST["date_of_birth"] ?? "";
    $newsletter = isset($_POST["newsletter"])? 1:0;

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
        error("-1", "Empty input fields.", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
        exit;
    }

    // REGEX EMAIL
    /* https://en.wikipedia.org/wiki/Email_address */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error("-1", "EMAIL pattern NOT valid.", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
        exit;
    }

    // REGEX DATE OF BIRTH dd/mm/yyyy
    if ($date_of_birth && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
        error("-1", "Date of birth pattern NOT valid.", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
        exit;
    }

    /* -- ERROR | passwords (mis)matching -- */
    if ($password != $password_confirm) {
        error("-1", "Mismatched passwords.", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
        exit;
    }
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    /* DB */
    $conn = DB::connect("\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");

    $email = $conn->real_escape_string($email);
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $date_of_birth = $conn->real_escape_string($date_of_birth);
    $password = $conn->real_escape_string($password);
    $password_confirm = $conn->real_escape_string($password_confirm);

    DB::p_stmt_no_select($conn,
        "INSERT INTO Users VALUES (NULL, ?, ?, ?, ?, 0, ?, null, null, ?);",
        ["s", "s", "s", "s", "s", "i"],
        [$first_name, $last_name, $email, $hash_password, $date_of_birth, $newsletter],
        "\controllers\auth\\registration.php",
        "/f1_project/views/public/auth/registration.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
        exit;
    }


    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Registration completed successfully.";
    header("Location: /f1_project/views/public/auth/login.php");

} else {
    error("-1", "Input fields NOT provided.", "\controllers\auth\\registration.php", "/f1_project/views/public/auth/registration.php");
    exit;
}