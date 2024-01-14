<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("controllers/auth/auth.php");

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {

    if (isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["price"]) && isset($_POST["team_id"])) {

        /* CLEANING INPUT */
        $id = preg_replace('/\s+/', '', $_POST["id"]);
        $title = preg_replace('/\s+/', ' ', $_POST["title"]);
        $desc = preg_replace('/\s+/', ' ', $_POST["desc"]??"");
        $price = preg_replace('/\s+/', '', $_POST["price"]);
        $team_id = preg_replace('!\s+!', '', $_POST["team_id"]);
        $color = preg_replace("/\s+/", ";", strtolower($_POST["color"]??""));
        $size = preg_replace("/\s+/", ";", strtolower((isset($_POST["size"]) && !preg_match('/^\s*$/', $_POST["size"]))? $_POST["size"] : PRODUCTS_DEFAULT_SIZE ));
        $img_url = [];
        if (isset($_POST["img_url_1"])) {
            $img_url[0] = $_POST["img_url_1"]?:"";
        }
        if (isset($_POST["img_url_2"])) {
            $index = !($img_url[0] === "");
            $img_url[$index] = $_POST["img_url_2"]?:"";
        }

        /* -- ERROR | Empty input fields -- */
        if ($id == "" || $id == " "
            || $title == "" || $title == " "
            || $price == "" || $price == " "
            || $team_id == "" || $team_id == " ") {
            error("-1", "Empty input fields.", "\controllers\store\\update_profile.php", "/f1_project/views/private/store/update_profile.php?id=$id");
            exit;
        }

        // REGEX PRICE xx.yy
        if (!preg_match("/^\d+([,.]\d{1,2})?$/", $price)) {
            error("-1", "Price NOT valid.", "\controllers\store\\update_profile.php", "/f1_project/views/private/store/update_profile.php?id=$id");
            exit;
        }
        $price = preg_replace("/,/", ".", $price);


        // TODO: REGEX img url ?? è necessario ??
        /*if ($date_of_birth && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
            error("-1", "Date of birth pattern NOT valid.", "registration.php", "/f1_project/views/public/auth/registration.php");
            exit;
        }*/

        /* CHECK INPUT LENGTHS */

        /* DB */
        $conn = DB::connect("\controllers\store\\update_profile.php", "/f1_project/views/private/store/update_profile.php?id=$id");
        $price = number_format($price, 2) * 100;
        $img_url_str = implode("\t", $img_url);
        $team_id = intval($team_id);

        /* CHECK INPUT LENGTHS */
        // $input_array = [$title, $desc, $price, $img_url, $team_id, $color, $size];
        $i = 0;
        foreach ([$id, $title, $desc, $price, $img_url_str, $team_id, $color, $size] as $input) {
            if (PRODUCTS_MAX_LENGTHS[$i] >= 0 && strlen($input) > PRODUCTS_MAX_LENGTHS[$i]) {
                $tmp = ucfirst(PRODUCTS_ARRAY[$i]);
                error("500", "$tmp is TOO long.", "\controllers\store\\update_profile.php", "/f1_project/views/private/store/update_profile.php?id=$id");
                exit;
            }
            $i++;
        }

        DB::p_stmt_no_select($conn,
            "UPDATE Products SET title=?, description=?, price=?, img_url=?, team_id=?, color=?, size=? WHERE id = ?",
            ["s", "s", "i", "s", "i", "s", "s", "i"],
            [$title, $desc, $price, $img_url_str, $team_id, $color, $size, $id],
            "\controllers\store\\update_profile.php",
            "/f1_project/views/private/store/update_profile.php?id=$id");

        if (!$conn->close()) {
            error("500", "conn_close()", "\controllers\store\\update_profile.php", "/f1_project/views/private/store/update_profile.php?id=$id");
            exit;
        }

        $_SESSION["success"] = 1;
        $_SESSION["success_msg"] = "Product updated successfully";
        header("Location: /f1_project/views/private/store/all.php");

    } else {
        error("500", "Fields not provided.", "\controllers\store\\update_profile.php", "/f1_project/views/private/store/all.php");
    }
} else {
    $_SESSION['redirection'] = "/f1_project/controllers/store/update_profile.php?id=${${$_POST['id']??''}}";
    error("401", "Unauthorised access!", "\controllers\store\\update_profile.php", "/f1_project/views/public/auth/login.php");
}
exit;