<?php
require_once("../../auth/auth.php");
require_once ("../../DB/DB.php");
require_once("../../utility/utility_func.php");
require_once("../../utility/msg_error.php");

if(session_status() == PHP_SESSION_NONE) session_start();
unset($_SESSION["dont_show_in_nav"]);
[$login_allowed, $user] = check_cookie();

if (check_admin_auth($user)) {
    set_session($user);

    if($_SESSION["id"] == $_GET["id"]) {
        msg_err_user_delete("It is not possible to delete the account you are using.");
        exit;
    }

    $conn = DB::connect();
    $check_role = check_user_role($conn,
        [$_GET["id"]],
        "/f1_project/views/private/user_delete.php",
        "/f1_project/views/private/user_delete.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "/f1_project/views/private/user_delete.php", "/f1_project/views/private/user_delete.php");
        exit;
    }

    if($check_role){
        msg_err_user_delete("You cannot delete an administrator.");
        exit;
    }

    $conn = DB::connect();
    DB::p_stmt_no_select($conn,
        "DELETE FROM Users WHERE id=?",
        ["i"], [$_GET["id"]],
        "user_delete.php",
        "user_delete.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "user_detail.php", "/f1_project/views/private/table_users.php");
        exit;
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Account deleted.";
    header("location:  /f1_project/views/private/table_users.php");
    exit;
}
else {
    error("401", "not_authorized", "user_delete.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}