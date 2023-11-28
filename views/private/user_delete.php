<?php
require_once("../../auth/auth.php");
require_once("../../error_handling.php");
require_once ("../../DB/DB.php");

if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);
    $conn = DB::connect();
    if($_SESSION["id"] != $_GET["id"]) {
        DB::p_stmt_no_select($conn,
            "DELETE FROM Users WHERE id=?",
            ["i"], [$_GET["id"]], "user_delete.php", "user_delete.php");
        if (!$conn->close()) {
            error("500", "conn_close()", "user_detail.php", "dashboard.php");
            exit;
        }
        header("location: dashboard.php");
        exit;
    }
    /*
     * else messaggio lato client per dire utente che non può eliminare l'account collegato
     */
}
else {
    error("401", "not_authorized", "user_delete.php", "../public/login_form.php", "Unauthorized access.");
    exit;
}