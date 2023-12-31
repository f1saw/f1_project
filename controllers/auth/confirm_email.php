<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("controllers/auth/auth.php");

if (isset($_SESSION["tmp_fname"]) && isset($_SESSION["tmp_lname"]) && isset($_SESSION["tmp_email"]) && isset($_SESSION["tmp_pass"]) && isset($_SESSION["tmp_cpass"]) && isset($_SESSION["tmp_hpass"])) {

    $conn = DB::connect("\auth\confirm_email.php", "/f1_project/views/public/registration.php");

    $hash_password = $_SESSION["tmp_hpass"];

    $email = $conn->real_escape_string($_SESSION["tmp_email"]);
    $first_name = $conn->real_escape_string($_SESSION["tmp_fname"]);
    $last_name = $conn->real_escape_string($_SESSION["tmp_lname"]);
    $password = $conn->real_escape_string($_SESSION["tmp_pass"]);
    $password_confirm = $conn->real_escape_string($_SESSION["tmp_cpass"]);
    unset($_SESSION["tmp_fname"]);
    unset($_SESSION["tmp_lname"]);
    unset($_SESSION["tmp_email"]);
    unset($_SESSION["tmp_pass"]);
    unset($_SESSION["tmp_cpass"]);
    unset($_SESSION["tmp_hpass"]);

    if (isset($_SESSION["tmp_date_of_birth"])) {
        $date_of_birth = $conn->real_escape_string($_SESSION["tmp_date_of_birth"]);
        unset($_SESSION["tmp_date_of_birth"]);
    }

    if(isset($_SESSION["tmp_news"])){
        $newsletter = $_SESSION["tmp_news"];
        unset($_SESSION["tmp_news"]);
    }

    DB::p_stmt_no_select($conn,
        "INSERT INTO Users VALUES (NULL, ?, ?, ?, ?, 0, ?, null, null, ?);",
        ["s", "s", "s", "s", "s", "i"],
        [$first_name, $last_name, $email, $hash_password, $date_of_birth??null, $newsletter??null],
        "\auth\confirm_email.php",
        "/f1_project/views/public/registration.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "\auth\confirm_email.php", "/f1_project/views/public/registration.php");
        exit;
    }

    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Registration completed successfully.";
    $_SESSION["confirm_email"] = true;
    header("Location: /f1_project/views/public/confirm.html");
} else {
    error("-1", "Input fields NOT provided.", "\auth\confirm_email.php", "/f1_project/views/public/registration.php");
    exit;
}