<?php

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

if (session_status() == PHP_SESSION_NONE) session_start();

require_once("auth/auth.php");
require_once("utility/error_handling.php");
require_once ("utility/store.php");
require_once ("DB/DB.php");
require_once("views/partials/alert.php") ;

[$login_allowed, $user] = check_cookie();
if (!check_user_auth($user)) {
    $_SESSION['redirection'] = "/f1_project/views/private/table_users.php";
    error("401", "not_authorized", "table_users.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
set_session($user);

$conn = DB::connect("orders/all.php", "/f1_project/views/private/dashboard.php");
$orders = (array)DB::get_record_by_field($conn,
    "SELECT orders.id AS 'Orders.id', orders.date AS 'Orders.date', orders.amount AS 'Orders.amount', 
                                products.id AS 'Products.id', products.title AS 'Products.title', products.img_url AS 'Products.img_url', 
                                orders_products.size AS 'Orders_Products.size', orders_products.quantity AS 'Orders_Products.quantity', orders_products.unit_price AS 'Orders_Products.unit_price'
                           FROM orders_products 
                                JOIN orders ON orders_products.order_id = orders.id 
                                JOIN products ON orders_products.product_id = products.id
                           WHERE orders.user_id = ?;",
    ["i"],
    [$user["Users.id"]],
    "orders/all.php",
    "/f1_project/views/private/dashboard.php");
$num_orders = count($orders);

if (!$conn->close()) {
    error("500", "conn_close()", "orders/all.php", "/f1_project/views/private/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <title>User | Orders</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/table_style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script> $(document).ready( function () { $('#table').DataTable(); }); </script>
</head>

<body class="vh-100 dark">
    <div class="container-fluid">
        <?php include("views/partials/navbar.php") ?>

        <div class="flex-container d-flex flex-column justify-content-center align-items-center mt-3 mt-md-5">
            <div class="container-element col-12 col-md-9">
                <h2 class="mb-4 mb-md-5 text-start">Your orders</h2>

                <?php if ($num_orders > 0) { ?>

                    <?php succ_msg_alert(); ?>
                    <?php err_msg_alert(); ?>

                    <table id="table" class="display">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">PRODUCT</th>
                            <th class="text-center">SIZE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center fit-content col-2">IMGs</th>
                            <th class="text-center">DATE</th>
                            <th class="text-center">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        /* $orders_post_processed = [];
                        foreach ($orders as $order) {
                            if ($orders_post_processed[$order["Orders.id"]] === null) {
                                $orders_post_processed[$order["Orders.id"]] = [
                                        "titles" => [...$orders["Products.title"]]
                                ];
                            }
                        }

                        $titles = []; */
                        $orders_id = [];

                        $i = 0;
                        foreach ($orders as $order) {
                            if (!in_array($order["Orders.id"], $orders_id)) {
                                $i++;
                                $orders_id[] = $order["Orders.id"];
                            } ?>
                            <tr>
                                <th class='text-center'>
                                    <?php echo $i ?>
                                </th>
                                <td class="text-center">
                                    <a href="/f1_project/views/public/store/product.php?id=<?php echo $order["Products.id"] ?>" target="_blank" class="text-decoration-none"><?php echo $order["Products.title"] ?></a>
                                </td>
                                <td class="text-center">
                                    <?php echo strtoupper($order["Orders_Products.size"]) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $order["Orders_Products.quantity"] ?>
                                </td>
                                <td class="text-center">
                                    <img style="width: 60px; height: 40px; object-fit: contain;" src="<?php echo $order["Products.img_url"]; ?>" alt="Profile pictures.">
                                </td>
                                <td class='text-center'>
                                    <?php echo $order["Orders.date"] ?>
                                </td>
                                <td class='text-center'>
                                    <?php [$int, $dec] = str2int_dec($order["Orders_Products.unit_price"]  * $order["Orders_Products.quantity"]); ?>
                                    € <?php echo $int . "." . $dec ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="alert border-light text-dark fade show d-flex align-items-center justify-content-center mt-4 col-12" role="alert">
                        <span class="material-symbols-outlined">description</span>
                        <span class="mx-2">
                            <b>INFO</b>&nbsp;| No Data available!
                        </span>
                    </div>
                <?php } ?>
            </div>
            <!-- TODO: just for testing -->
            <?php session_destroy(); ?>
        </div>
    </div>
</body>
</html>