<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");

[$login_allowed, $user] = check_cookie();
if (!check_admin_auth($user)) {
    error("401", "not_authorized", "\controllers\users\delete.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
    exit;
}
set_session($user);

if (!isset($_GET["id"]) || !$_GET["id"]) {
    error("500", "id_not_given", "\controllers\users\delete.php", "/f1_project/views/private/users/all.php", "ID NOT given.");
    exit;
}

unset($_SESSION["dont_show_in_nav"]);

if($_SESSION["id"] == $_GET["id"]) {
    msg_err_user_delete("It is not possible to delete the account you are using.");
    exit;
}

$conn = DB::connect("\controllers\users\delete.php", "/f1_project/views/private/users/all.php");

// TODO: check_user_role() equivale a check_admin_auth() ?
$check_role = check_user_role($conn,
    [$_GET["id"]],
    "\controllers\users\delete.php",
    "/f1_project/controllers/users/delete.php");

if (!$conn->close()) {
    error("500", "conn_close()", "\controllers\users\delete.php", "/f1_project/views/private/users/all.php");
    exit;
}

if($check_role){
    msg_err_user_delete("You cannot delete an administrator.");
    exit;
}

$conn = DB::connect("\controllers\users\delete.php", "/f1_project/views/private/users/all.php");
DB::p_stmt_no_select($conn,
    "DELETE FROM Users WHERE id = ?",
    ["i"],
    [$_GET["id"]],
    "\controllers\users\delete.php",
    "/f1_project/controllers/users/delete.php");

if (!$conn->close()) {
    error("500", "conn_close()", "\controllers\users\delete.php", "/f1_project/views/private/users/all.php");
    exit;
}

$_SESSION["success"] = 1;
$_SESSION["success_msg"] = "Account deleted.";
header("location:  /f1_project/views/private/users/all.php");