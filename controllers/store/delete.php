<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    $conn = DB::connect("\controllers\store\delete.php", "/f1_project/views/private/store/all.php");
    DB::p_stmt_no_select($conn,
        "DELETE FROM Products WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "\controllers\store\delete.php",
        "/f1_project/views/private/store/all.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "\controllers\store\delete.php", "/f1_project/views/private/store/all.php");
        exit;
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Product deleted.";
    header("location:  /f1_project/views/private/store/all.php");
}
else {
    error("401", "not_authorized", "\controllers\store\delete.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
}
exit;