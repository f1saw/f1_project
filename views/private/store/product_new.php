<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once("utility/error_handling.php");
require_once ("DB/DB.php");
require_once ("auth/auth.php");


if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if ($login_allowed) {

    if (isset($_POST["title"]) && isset($_POST["desc"]) && isset($_POST["price"]) && isset($_POST["img_url"])) {

        /* CLEANING INPUT */
        $title = htmlentities($_POST["title"]);
        $desc = htmlentities($_POST["desc"]);
        $price = preg_replace('!\s+!', '', $_POST["price"]);
        $price = htmlentities($_POST["price"]);
        $img_url = $_POST["img_url"]? htmlentities($_POST["img_url"]):"";
        // TODO appropriate team id
        // $team_id = $_POST["team_id"] ?? -1;
        $team_id = -1;

        // REGEX PRICE xx.yy
        if ($price && !preg_match("/^\d+([,.]\d{1,2})?$/", $price)) {
            error("-1", "Price NOT valid.", "product_new.php", "/f1_project/views/private/dashboard.php");
            exit;
        }
        $price = preg_replace("/,/", ".", $price);

        // TODO: REGEX img url ?? è necessario ??
        /*if ($date_of_birth && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
            error("-1", "Date of birth pattern NOT valid.", "registration.php", "/f1_project/views/public/registration_form.php");
            exit;
        }*/

        /* DB */
        $conn = DB::connect("product_new.php", "/f1_project/views/private/dashboard.php");
        $title = $conn->real_escape_string($title);
        $desc = $conn->real_escape_string($desc);
        $price = number_format($conn->real_escape_string($price), 2) * 100;
        $img_url = $conn->real_escape_string($img_url);
        $team_id = intval($conn->real_escape_string($team_id));

        DB::p_stmt_no_select($conn,
        "INSERT INTO Products VALUES (NULL, ?, ?, ?, ?, ?)",
        ["s", "s", "i", "s", "i"],
        [$title, $desc, $price, $img_url, $team_id],
        "product_new.php",
        "/f1_project/views/private/dashboard.php");

        if (!$conn->close()) {
            error("500", "conn_close()", "product_new.php", "/f1_project/views/private/dashboard.php");
            exit;
        }

        $_SESSION["success"] = 1;
        $_SESSION["success_msg"] = "Product created successfully";
        header("Location: /f1_project/views/private/dashboard.php");

    } else {
        error("500", "Fields not provided.", "product_new.php", "/f1_project/views/private/dashboard.php");
    }
} else {
    error("401", "Unauthorised access!", "product_new.php", "/f1_project/views/public/login_form.php");
}
exit;





