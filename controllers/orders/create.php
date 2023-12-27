<!-- TODO: LocalStorage.clear() -->
<?php

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once ("utility/store.php");
require_once ("utility/utility_func.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("auth/auth.php");
require_once ("controllers/mail.php");

if (session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if ($login_allowed) {

    if (isset($_POST["ids"]) && isset($_POST["titles"]) && isset($_POST["teams"]) && isset($_POST["quantities"]) &&  isset($_POST["imgs"]) && isset($_POST["prices"]) && isset($_POST["sizes"]) && isset($_POST["total"])) {

        /* CLEANING INPUT */
        $ids = htmlentities($_POST["ids"]);
        $titles = htmlentities($_POST["titles"]);
        $teams = htmlentities($_POST["teams"]);
        $quantities = htmlentities($_POST["quantities"]);
        $imgs = htmlentities($_POST["imgs"]);
        $prices = htmlentities($_POST["prices"]);
        $sizes = htmlentities($_POST["sizes"]);
        $total = htmlentities($_POST["total"]);

        /* DB */
        $conn = DB::connect("orders/create.php", "/f1_project/views/public/store/cart.php");
        $ids = $conn->real_escape_string($ids);
        $titles = $conn->real_escape_string($titles);
        $teams = $conn->real_escape_string($teams);
        $quantities = $conn->real_escape_string($quantities);
        $imgs = $conn->real_escape_string($imgs);
        $prices = $conn->real_escape_string($prices);
        $sizes = $conn->real_escape_string($sizes);
        $total = $conn->real_escape_string($total);

        try {
            $order_id = generate_random_string(29);

            DB::p_stmt_no_select($conn,
                "INSERT INTO orders VALUES (?, ?, ?, ?, ?);",
                ["s", "i", "s", "s", "i"],
                [$order_id, $user["Users.id"], (new DateTime())->format('Y-m-d'), "Via ...", $total],
                "orders/create.php",
                "/f1_project/views/public/store/cart.php");

            $products_id_array = explode("\t", $ids);
            $quantities_array = explode("\t", $quantities);
            $prices_array = explode("\t", $prices);
            $sizes_array = explode("\t", $sizes);
            //
            $imgs_array = explode("\t", $imgs);
            $titles_array = explode("\t", $titles);
            $teams_array = explode("\t", $teams);
            for ($i = 0; $i < count($products_id_array) - 1; $i++) {
                DB::p_stmt_no_select($conn,
                    "INSERT INTO orders_products VALUES (?, ?, ?, ?, ?);",
                    ["s", "i", "s", "i", "i"],
                    [$order_id, $products_id_array[$i], $sizes_array[$i], $quantities_array[$i], $prices_array[$i]],
                    "orders/create.php",
                    "/f1_project/views/public/store/cart.php");
            }


            $subject = "Ready to goooo! You've just completed your order :)";
            $body = "";
            for ($i = 0; $i < count($products_id_array) - 1; $i++) {
                $size = strtoupper($sizes_array[$i]);
                [$int, $dec] = str2int_dec($prices_array[$i]);
                $body .= "$titles_array[$i]<br>";
                $body .= "Size: $size<br>";
                $body .= "[$quantities_array[$i]x <strong>$int.$dec &euro;</strong>]<br>";
                $body .= "<img src='$imgs_array[$i]' width='65px;' alt='product picture'>";
                $body .= "<hr>";
            }

            [$int, $dec] = str2int_dec($total);
            $body .= "Total: <strong>$int.$dec &euro;</strong>";
            send_mail([$user["Users.email"]], $subject, $body);

            if (!$conn->close()) {
                error("500", "conn_close()", "orders/create.php", "/f1_project/views/public/store/cart.php");
                exit;
            }

            $_SESSION["success"] = 1;
            $_SESSION["success_msg"] = "Order created successfully";
            header("Location: /f1_project/views/public/store/cart.php");

        } catch (Exception $e) {
            error("500", "generate_random_string(): $e", "orders/create.php", "/f1_project/views/public/store/cart.php");
        }


    } else {
        error("500", "Fields not provided.", "orders/create.php", "/f1_project/views/public/store/cart.php");
    }
} else {
    error("401", "Unauthorised access!", "orders/create.php", "/f1_project/views/public/login_form.php");
}
exit;