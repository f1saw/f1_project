<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("auth/auth.php");


if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {

    if (isset($_POST["title"]) && isset($_POST["desc"]) && isset($_POST["price"]) && isset($_POST["color"]) && isset($_POST["team_id"]) && isset($_POST["size"])) {

        /* CLEANING INPUT */
        $title = preg_replace('/\s+/', '', htmlentities($_POST["title"]));
        $desc = preg_replace('/\s+/', '', htmlentities($_POST["desc"]));
        $price = preg_replace('/\s+/', '', htmlentities($_POST["price"]));
        $img_url = [];
        if (isset($_POST["img_url_1"])) {
            $img_url[0] = $_POST["img_url_1"]? htmlentities($_POST["img_url_1"]):"";
        }
        if (isset($_POST["img_url_2"])) {
            $index = !($img_url[0] === "");
            $img_url[$index] = $_POST["img_url_2"]? htmlentities($_POST["img_url_2"]):"";
        }
        $team_id = preg_replace('!\s+!', '', htmlentities($_POST["team_id"]));
        $color = preg_replace("/\s+/", ";", strtolower(htmlentities($_POST["color"])));
        $size = preg_replace("/\s+/", ";", strtolower(htmlentities($_POST["size"])));

        /* -- ERROR | Empty input fields -- */
        if ($title == "" || $title == " "
            || $desc == "" || $desc == " "
            || $price == "" || $price == " "
            || $team_id == "" || $team_id == " "
            || $color == "" || $color == " "
            || $size == "" || $size == " ") {
            error("-1", "Empty input fields.", "store\create.php", "/f1_project/views/private/store/new.php");
            exit;
        }

        // REGEX PRICE xx.yy
        if ($price && !preg_match("/^\d+([,.]\d{1,2})?$/", $price)) {
            error("-1", "Price NOT valid.", "store\create.php", "/f1_project/views/private/store/new.php");
            exit;
        }
        $price = preg_replace("/,/", ".", $price);

        // TODO: REGEX img url ?? è necessario ??
        /*if ($date_of_birth && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
            error("-1", "Date of birth pattern NOT valid.", "registration.php", "/f1_project/views/public/registration_form.php");
            exit;
        }*/

        /* DB */
        $conn = DB::connect("create.php", "/f1_project/views/private/store/new.php");
        $title = $conn->real_escape_string($title);
        $desc = $conn->real_escape_string($desc);
        $price = number_format($conn->real_escape_string($price), 2) * 100;
        $img_url_str = implode("\t", $img_url);
        $img_url_str = $conn->real_escape_string($img_url_str);
        $team_id = intval($conn->real_escape_string($team_id));
        $color = $conn->real_escape_string($color);
        $size = $conn->real_escape_string($size);

        DB::p_stmt_no_select($conn,
        "INSERT INTO Products VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)",
        ["s", "s", "i", "s", "i", "s", "s"],
        [$title, $desc, $price, $img_url_str, $team_id, $color, $size],
        "create.php",
        "/f1_project/views/private/store/new_form.php");

        if (!$conn->close()) {
            error("500", "conn_close()", "create.php", "/f1_project/views/private/store/new.php");
            exit;
        }

        $_SESSION["success"] = 1;
        $_SESSION["success_msg"] = "Product created successfully";
        header("Location: /f1_project/views/private/store/all.php");

    } else {
        error("500", "Fields not provided.", "create.php", "/f1_project/views/private/store/new.php");
    }
} else {
    error("401", "Unauthorised access!", "create.php", "/f1_project/views/public/login_form.php");
}
exit;