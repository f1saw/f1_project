<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("utility/utility_func.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("controllers/auth/auth.php");

[$login_allowed, $user] = check_cookie();
if (!$login_allowed) {

    if (isset($_POST["email"]) && isset($_POST["pass"])) {

        /* CLEANING INPUT */
        $email = preg_replace('!\s+!', '', $_POST["email"]);
        $password = trim($_POST["pass"]);
        $remember_me = isset($_POST["remember_me"]) ? 1:0;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error("-1", "Email not an email", "\auth\login.php", "/f1_project/views/public/auth/login.php");
            exit;
        }

        /* DB */
        $conn = DB::connect("\auth\login.php", "/f1_project/views/public/auth/login.php");

        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);
        $remember_me = $conn->real_escape_string($remember_me);

        $user = DB::get_record_by_field($conn,
            "SELECT Users.id AS 'Users.id', Users.first_name AS 'Users.first_name', Users.last_name AS 'Users.last_name', Users.email AS 'Users.email', Users.password AS 'Users.password', Users.role AS 'Users.role', Users.date_of_birth AS 'Users.date_of_birth', Users.img_url AS 'Users.img_url', Users.newsletter AS 'Users.newsletter' FROM Users WHERE email = ?;",
            ['s'],
            [$email],
            "\auth\login.php",
            "/f1_project/views/public/auth/login.php")[0];


        if ($user && password_verify($password, $user["Users.password"])) {
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
                        "\auth\login.php",
                        "/f1_project/views/public/auth/login.php");

                    DB::p_stmt_no_select($conn,
                        "UPDATE Users SET cookie_id = ? WHERE id = ?;",
                        ["s", "i"],
                        [$cookie_id, $user["Users.id"]],
                        "\auth\login.php",
                        "/f1_project/views/public/auth/login.php");


                    /* TODO: controllo superfluo in quanto se ci fosse già un cookie, non si accederebbe a questa sezione di codice.
                                anche se sarebbe più sicuro, nel caso sarebbe da fare un SELECT * Cookies, for(cookies as cookie) if (password_match()) => already in DB.
                                potrebbe accadere incongruenza in caso di modifiche manuali (tipo rimozione manuale di cookie_id da User)

                        $cookie = DB::get_record_by_field($conn,
                        "SELECT id FROM Cookies WHERE id = ?;",
                        ["s"],
                        [$user["cookie_id"]],
                        "login.php",
                        "../views/public/auth/login.php");

                    if ($cookie) {

                        DB::p_stmt_no_select($conn,
                            "UPDATE Cookies SET id = ?, expiration_date = ? WHERE id = ?;",
                            ["s", "i", "s"],
                            [$cookie_id, $cookie_exp_date, $user["cookie_id"]],
                            "login.php",
                            "../views/public/auth/login.php"
                        );
                    } else {

                        DB::p_stmt_no_select($conn,
                            "INSERT INTO Cookies VALUES (?, ?);",
                            ["s", "i"],
                            [$cookie_id, $cookie_exp_date],
                            "login.php",
                            "../views/public/auth/login.php");

                        DB::p_stmt_no_select($conn,
                        "UPDATE Users SET cookie_id = ? WHERE id = ?;",
                        ["s", "i"],
                        [$cookie_id, $user["id"]],
                        "login.php",
                        "../views/public/auth/login.php");
                    } */
                } catch (Exception $e) {
                    error("500", "generate_random_string()", "\auth\login.php", "/f1_project/views/public/auth/login.php");
                    exit;
                }
            }

            $login_allowed = 1;
        } else {
            $login_allowed = 0;
        }
        if (!$conn->close()) {
            error("500", "conn_close()", "\auth\login.php", "/f1_project/views/public/auth/login.php");
            exit;
        }

    } else {
        error("401", "Fields not provided.", "\auth\login.php", "/f1_project/views/public/auth/login.php");
        exit;
    }
}


if ($login_allowed) {
    set_session($user);

    if(isset($_SESSION["redirection"])) {
        header("Location: {$_SESSION['redirection']}");
        unset($_SESSION['redirection']);
    }
    else {
        header("Location: /f1_project/views/public/index.php");
    }

} else {
    error("401", "Email and pwd NOT correct", "\auth\login.php", "/f1_project/views/public/auth/login.php");
}
exit;