<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("auth/auth.php");
require_once("utility/error_handling.php");
require_once("views/partials/alert.php");
require_once ("utility/store.php");
require_once ("DB/DB.php");
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store/cart.css">

</head>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("views/partials/navbar_store.php")?>


    <?php succ_msg_alert(); ?>
    <?php err_msg_alert(); ?>


    <main class="container-fluid mt-5">

        <div class="text-light">
            <span class="text-light h2 d-flex align-items-end gap-3">
                Cart
                <span class="material-symbols-outlined text-danger py-1">shopping_cart</span>
            </span>
        </div>

        <hr class="mb-5 rounded">

        <div class="row d-flex justify-content-center gap-4">

            <div class="col-12 col-sm-4 col-lg-3 text-center text-sm-end">
                <a href="/f1_project/views/public/store/product.php?id=1" target="_blank" class="text-decoration-none">
                    <img src="https://m.media-amazon.com/images/I/71w8u+Y6YZL._AC_AA180_.jpg" alt="">
                </a>
            </div>
            <div class="col-12 col-sm-4 text-center text-sm-start">
                <a href="/f1_project/views/public/store/product.php?id=1" target="_blank" class="text-decoration-none text-light d-flex flex-column justify-content-between align-items-start">
                    <span>
                        Cavo Console compatibile Cisco, 1,8 m, FTDI USB a RJ45/Windows 7/8/Vista/Mac/Linux/RS232 (tipo A)
                        <hr class="rounded my-thin-grey">
                        Ethernet
                    </span>
                    <br>
                    <button class="bg-transparent border-0 p-0 text-info d-flex gap-2 mt-3">
                        <span class="material-symbols-outlined">delete</span>
                        Remove
                    </button>
                </a>
            </div>

            <div class="col-12 col-sm-2 text-end ms-auto">
                <strong>12.55 €</strong>
            </div>
        </div>
        <hr class="rounded">
        <div class="row d-flex justify-content-between gap-3">
            <form action="#" method="POST" class="col-12 col-md-5">
                <button type="submit" class="btn btn-warning d-flex gap-2 hover-yellow">
                    <span class="material-symbols-outlined">credit_card</span>
                    <span class="text">Complete order</span>
                </button>
            </form>
            <label class="col-12 col-md-5 text-end">
                Totale provvisorio (1 articolo): <strong>12.55 €</strong>
            </label>
        </div>

        <!-- <div class="mx-auto alert alert-no-data border-light fade show d-flex flex-column justify-content-center align-items-center mt-4 col-12" role="alert">
            <div class="mx-2 h2">Your cart is empty :(</div>
            <label class="lbl-shop">
                <a href="/f1_project/views/public/store/store.php" class="text-decoration-none"><strong>Click here</strong></a> to go to the shop
            </label>
        </div> -->






        <!-- <table id="cart-table" class="mx-auto">
            <thead>
            <tr>
                <th class="text-center fit-content col-2">IMGs</th>
                <th class="text-center col-4">TITLE</th>
                <th class="text-center">TEAM</th>
                <th class="text-end">PRICE</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">
                    <img src="https://m.media-amazon.com/images/I/71w8u+Y6YZL._AC_AA180_.jpg" alt="">
                </td>
                <td class="text-center">
                    Cavo Console compatibile Cisco, 1,8 m, FTDI USB a RJ45/Windows 7/8/Vista/Mac/Linux/RS232 (tipo A)
                </td>
                <td class="text-center">
                    Ethernet
                </td>
                <td class="text-end">
                    <strong>12.55 €</strong>
                </td>
            </tr>
            </tbody>
        </table> -->
    </main>
</body>

<script src="/f1_project/assets/js/store.js"></script>
</html>