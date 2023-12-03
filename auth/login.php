<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once("error_handling.php");
require_once ("DB/DB.php");
require_once ("auth/auth.php");



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
if (!$login_allowed) {

    if (isset($_POST["email"]) && isset($_POST["pass"])) {

        /* CLEANING INPUT */
        $email = preg_replace('!\s+!', '', $_POST["email"]);
        $password = trim($_POST["pass"]);
        $remember_me = isset($_POST["remember_me"]) ? 1:0;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error("-1", "Email not an email", "login.php", "../views/public/login_form.php");
            exit;
        }


        /* DB */
        $conn = DB::connect("login.php", "../views/public/login_form.php");

        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $remember_me = $conn->real_escape_string($remember_me);

        $user = DB::get_record_by_field($conn,
            "SELECT * FROM Users WHERE email = ?;",
            ['s'],
            [$email],
            "login.php",
            "../views/public/login_form.php");

        if ($user && password_verify($password, $user["password"])) {
            if ($remember_me) {
                try {

                    $cookie_id = generate_random_string(255);
                    $cookie_value = generate_random_string(255); // TODO: length from file
                    $cookie_exp_date = time() + 3600*24*30; // TODO: expiration from file
                    setcookie("my_f1_cookie_id", $cookie_id, $cookie_exp_date, "/");
                    setcookie("my_f1_cookie_value", $cookie_value, $cookie_exp_date, "/");

                    $cookie_value = password_hash($cookie_value, PASSWORD_DEFAULT);

                    DB::p_stmt_no_select($conn,
                        "INSERT INTO Cookies VALUES (?, ?, ?);",
                        ["s", "s", "i"],
                        [$cookie_id, $cookie_value, $cookie_exp_date],
                        "login.php",
                        "../views/public/login_form.php");

                    DB::p_stmt_no_select($conn,
                        "UPDATE Users SET cookie_id = ? WHERE id = ?;",
                        ["s", "i"],
                        [$cookie_id, $user["id"]],
                        "login.php",
                        "../views/public/login_form.php");


                    /* TODO: controllo superfluo in quanto se ci fosse già un cookie, non si accederebbe a questa sezione di codice.
                                anche se sarebbe più sicuro, nel caso sarebbe da fare un SELECT * Cookies, for(cookies as cookie) if (password_match()) => already in DB.
                                potrebbe accadere incongruenza in caso di modifiche manuali (tipo rimozione manuale di cookie_id da User)

                        $cookie = DB::get_record_by_field($conn,
                        "SELECT id FROM Cookies WHERE id = ?;",
                        ["s"],
                        [$user["cookie_id"]],
                        "login.php",
                        "../views/public/login_form.php");

                    if ($cookie) {

                        DB::p_stmt_no_select($conn,
                            "UPDATE Cookies SET id = ?, expiration_date = ? WHERE id = ?;",
                            ["s", "i", "s"],
                            [$cookie_id, $cookie_exp_date, $user["cookie_id"]],
                            "login.php",
                            "../views/public/login_form.php"
                        );
                    } else {

                        DB::p_stmt_no_select($conn,
                            "INSERT INTO Cookies VALUES (?, ?);",
                            ["s", "i"],
                            [$cookie_id, $cookie_exp_date],
                            "login.php",
                            "../views/public/login_form.php");

                        DB::p_stmt_no_select($conn,
                        "UPDATE Users SET cookie_id = ? WHERE id = ?;",
                        ["s", "i"],
                        [$cookie_id, $user["id"]],
                        "login.php",
                        "../views/public/login_form.php");
                    } */
                } catch (Exception $e) {
                    error("500", "generate_random_string()", "login.php", "../views/public/login_form.php");
                    exit;
                }
            }

            $login_allowed = 1;
        } else {
            $login_allowed = 0;
        }
        if (!$conn->close()) {
            error("500", "conn_close()", "login.php", "../views/public/login_form.php");
            exit;
        }

    } else {
        error("401", "Fields not provided.", "login.php", "../views/public/login_form.php");
        exit;
    }
}


if ($login_allowed) {
    set_session($user);

    if(isset($_SESSION["redirection"])) {
        header("Location: {$_SESSION['redirection']}");
        unset($_SESSION['redirection']);
        exit;
    }
    else {
        header("Location: /f1_project/views/public/index.php");
        exit;
    }

} else {
    error("401", "Email and pwd NOT correct", "login.php", "../views/public/login_form.php");
    exit;
}






