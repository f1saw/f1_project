<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once "error_handling.php";
require_once "DB/DB.php";


if(session_status() == PHP_SESSION_NONE) session_start();

function set_session($user): void {
    if ($user && $user != []) {
        $_SESSION["s_id"] = session_id();
        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["first_name"] = $user["first_name"];
        $_SESSION["last_name"] = $user["last_name"];
        $_SESSION["date_of_birth"] = $user["date_of_birth"];
        $_SESSION["img_url"] = $user["img_url"];
        $_SESSION["newsletter"] = $user["newsletter"];
        $_SESSION["role"] = $user["role"];
    }
}

function check_cookie(): array {
    $user = [];
    $login_allowed = 0;

    if (isset($_COOKIE["my_f1_cookie_id"]) && isset($_COOKIE["my_f1_cookie_value"])) {
        $conn = DB::connect();
        $_COOKIE["my_f1_cookie_id"] = $conn->real_escape_string($_COOKIE["my_f1_cookie_id"]);
        $user = DB::get_record_by_field($conn,
            "SELECT * FROM Users JOIN Cookies ON Users.cookie_id = Cookies.id WHERE Cookies.id = ? AND Cookies.expiration_date > ?;",
            ["s", "i"],
            [$_COOKIE["my_f1_cookie_id"], time()]);
        if (!password_verify($_COOKIE["my_f1_cookie_value"], $user["value"]))
            $user = null;
        if (!$conn->close()) {
            error("500", "conn close error: $conn->error", "auth.php", ""); // TODO: generic error page
            exit;
        }

        if ($user !== null)
            $login_allowed = 1;
    }
    return [$login_allowed, $user];
}
function check_admin_auth($user = null): bool {
    return check_auth(1, $user);
}

function check_user_auth($user = null): bool {
    return check_auth(0, $user);
}

function check_auth($role, $user = null): bool {
    if ($user) {
        return $user["role"] >= $role;
    }

    [$login_allowed, $user] = check_cookie();
    return (($login_allowed && $user["role"] >= $role)
        || isset($_SESSION["role"]) && $_SESSION["role"] >= $role);
}