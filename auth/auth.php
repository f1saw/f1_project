<?php
require_once("../utils/error_handling.php");
require_once ("../DB/DB.php");

if(session_status() == PHP_SESSION_NONE) session_start();

function set_session($user): void {
    /* if ($user && $user != []) {
        $_SESSION["s_id"] = session_id();
        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];
    } */
}

function check_cookie(): array {
    /* $user = [];
    $login_allowed = 0;

    if (isset($_COOKIE["my_cookie"])) {

        $conn = DBUsers::connect();
        $_COOKIE["my_cookie"] = $conn->real_escape_string($_COOKIE["my_cookie"]);
        $user = DBUsers::get_user_by_field($conn,
            "SELECT * FROM Users WHERE cookie_id = ? AND cookie_exp_date > ?;",
            ["s", "i"],
            [$_COOKIE["my_cookie"], time()]);
        if (!$conn->close())
            error("500", "conn close error: $conn->error");

        if ($user !== null)
            $login_allowed = 1;
    }

    return [$login_allowed, $user]; */
    return [];
}

function check_admin_auth($user = null): bool {
    return check_auth(1, $user);
}

function check_user_auth($user = null): bool {
    return check_auth(0, $user);
}

function check_auth($role, $user = null): bool {
    /* if ($user) {
        return $user["role"] >= $role;
    }

    [$login_allowed, $user] = check_cookie();
    return (($login_allowed && $user["role"] >= $role)
        || isset($_SESSION["role"]) && $_SESSION["role"] >= $role); */
    return true;
}