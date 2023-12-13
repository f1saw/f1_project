<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once("auth/auth.php");
require_once ("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");

if(session_status() == PHP_SESSION_NONE) session_start();
[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    $conn = DB::connect("store/delete.php", "/f1_project/views/private/store/all.php");
    DB::p_stmt_no_select($conn,
        "DELETE FROM Products WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "store/delete.php",
        "/f1_project/views/private/store/all.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "store/delete.php", "/f1_project/views/private/store/all.php");
        exit;
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Product deleted.";
    header("location:  /f1_project/views/private/store/all.php");
}
else {
    error("401", "not_authorized", "store/delete.php", "/f1_project/views/private/store/all.php", "Unauthorized access.");
}
exit;