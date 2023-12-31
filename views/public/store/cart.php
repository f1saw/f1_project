<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("views/partials/alert.php");
require_once ("utility/store.php");
require_once ("DB/DB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store/store.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store/cart.css">
</head>

<body>
<div class="container-fluid bg-dark">

    <label id="order-success" class="d-none"><?php echo ($_SESSION["success"])??""; ?></label>
    <script>
        // JS script required at this point because it must be after the label defined at the previous row (row 30) in order to get its values,
        // and it must be before the include for the navbar (otherwise, an outdated cart would be considered during the render of the navbar)
        if ($("#order-success").text() !== "") {
            localStorage.clear();
        }
    </script>

    <!-- Nav -->
    <?php include ("views/partials/navbar_store.php")?>

    <?php succ_msg_alert(); ?>
    <?php err_msg_alert(); ?>

    <main class="container-fluid mt-0 mt-lg-5">

        <div class="text-light">
            <span class="text-light h2 d-flex align-items-end gap-3">
                Cart
                <span class="material-symbols-outlined text-danger py-1">shopping_cart</span>
            </span>
        </div>

        <hr class="mb-5 rounded">

        <!-- Loading circle -->
        <?php include ("views/partials/loading.php"); ?>

        <!-- PRODUCTS in CART -->
        <div id="cart-list" class="d-none row d-flex justify-content-center gap-4 item"></div>

        <!-- Empty cart alert -->
        <div id="cart-empty-alert" class="d-none mx-auto alert alert-no-data border-light fade show d-flex flex-column justify-content-center align-items-center mt-4 col-12" role="alert">
            <div class="mx-2 h2">Your cart is empty :(</div>
            <label class="lbl-shop">
                <a href="/f1_project/views/public/store/store.php" class="text-decoration-none"><strong>Click here</strong></a> to go to the shop
            </label>
        </div>

        <!-- Second body used to render "Complete order" button and the total cost -->
        <div id="second-body" class="d-none">
            <hr class="rounded mt-5">
            <div class="row d-flex justify-content-between gap-3 mt-4">
                <form action="/f1_project/controllers/orders/create.php" id="form-loading" method="POST" class="col-12 col-lg-5 mb-3 d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start align-items-center gap-4">

                    <input type="hidden" name="ids" id="ids" value="" required>
                    <input type="hidden" name="titles" id="titles" value="" required>
                    <input type="hidden" name="teams" id="teams" value="" required>
                    <input type="hidden" name="imgs" id="imgs" value="" required>
                    <input type="hidden" name="quantities" id="quantities" value="" required>
                    <input type="hidden" name="prices" id="prices" value="" required>
                    <input type="hidden" name="sizes" id="sizes" value="" required>
                    <input type="hidden" name="total" id="total" value="" required>

                    <button type="submit" class="mx-auto mx-md-0 btn btn-warning d-flex gap-2 hover-yellow">
                        <span class="material-symbols-outlined">credit_card</span>
                        <span class="text">Complete order</span>
                    </button>

                    <div>
                        <label for="address" class="form-label text-box"><strong>ADDRESS</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="address-addon">home</span>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Your address" aria-describedby="address-addon" required>
                        </div>
                    </div>
                </form>

                <!-- Loading circle -->
                <?php include ("views/partials/loading.php"); ?>

                <label class="col-12 col-lg-4 text-center text-lg-end">
                    <span>
                        Total (<span id="count-items"></span>): <strong class="total-price"></strong>
                    </span>
                </label>
            </div>
        </div>

    </main>
</body>

<script src="/f1_project/assets/js/navbar.js"></script>
<script src="/f1_project/assets/js/store/cart.js"></script>
</html>