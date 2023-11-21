<?php
require_once("../utils/error_handling.php");
require_once ("../DB/DB.php");
require_once ("auth.php");

if(session_status() == PHP_SESSION_NONE) session_start();


/**
 * @throws Exception
 */
function generate_random_string($length): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = "";
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[random_int(0, $characters_length - 1)];
    }
    return $random_string;
}



[$login_allowed, $user] = check_cookie();
if (!$login_allowed && isset($_POST["email"]) && isset($_POST["pass"])) {
    $email = preg_replace('!\s+!', '', $_POST["email"]);
    $password = trim($_POST["pass"]);
    $remember_me = isset($_POST["remember_me"]) ? 1:0;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error("-1", "Email not an email", "login.php", "login_form.php");
    }



    /* DB */
    $conn = DB::connect();

    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $remember_me = $conn->real_escape_string($remember_me);

    $user = DB::get_record_by_field($conn,
        "SELECT * FROM Users WHERE email = ?;",
        ['s'],
        [$email]);

    if ($user && password_verify($password, $user["password"])) {
        if ($remember_me) {
            try {
                // TODO: hash
                $cookie_id = generate_random_string(30);
            } catch (Exception $e) {
                $cookie_id = null;
                error("500", "generate_random_string()", "login.php", "login_form.php");
            }
            $cookie_exp_date = time() + 3600*24*30; // 30 days

        } else {
            $cookie_id = null;
            $cookie_exp_date = time() + 3600*24*30;;
        }
        setcookie("my_f1_cookie", $cookie_id, $cookie_exp_date);

        $sql = "BEGIN TRANSACTION;" .
            "UPDATE Users " .
                "SET cookie_id = ? " .
                "WHERE id = ?; " .
            "UPDATE Cookies " .
                "SET id = ? " .
                "expiration_date = ? " .
                "WHERE id = ?; " .
            "COMMIT;";
        DB::p_stmt_no_select($conn,
            $sql,
            ["s", "i", "i", "s", "s"],
            [$cookie_id, $user["id"], $cookie_id, $user["cookie_id"]],
        );

        $login_allowed = 1;
    } else {
        $login_allowed = 0;
    }
    if (!$conn->close())
        error("500", "conn_close()", "login.php", "login_form.php");

} else {
    error("401", "Fields not provided.");
}


if ($login_allowed) {
    set_session($user);
    header('Location: index.php');
} else {
    error("401", "Email and pwd NOT correct");
}