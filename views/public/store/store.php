<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/index_style.css">
    <link rel="stylesheet" href="../../../assets/css/store.css">

    <?php include("../../partials/head.php"); ?>
    <?php require_once("../../../auth/auth.php") ?>

    <?php require_once("../../../utility/error_handling.php"); ?>
    <?php require_once("../../partials/alert.php") ?>
    <?php require_once ("../../../utility/store.php") ?>
    <?php require_once ("../../../DB/DB.php"); ?>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("../../partials/navbar_store.php")?>

    <div class="w-100 d-flex flex-column gap-3">
        <h3 class="d-flex justify-content-center">
            Shop by Team
        </h3>
        <div id="shop-by-team" class="row d-flex justify-content-center align-items-center gap-5 p-3">
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/9a4b02b0-f73a-4bf7-af5a-dd9794260036.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/7699db10-0dff-47ff-ba47-ff92078a02fd.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/239e8493-e331-4a9f-a8ac-262d1c743e29.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/8a248b00-993b-4a19-8259-5b583b68c4b6.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/5bf95f16-e3ad-42da-bfdc-6bf13926f348.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/15466209-49af-4adc-b619-514a9fcbe8e3.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/5bfedd91-c84a-48a3-85d4-7c3da87cc72a.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/d9a775d3-e042-4434-9971-f51a8c83279b.svg" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/af401abe-7378-47aa-95df-1bf6ab81674a.svg" alt="">
            </a>
            <a href="#">
                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo_Haas_F1.png" alt="">
            </a>
            <a href="#">
                <img src="https://f1store2.formula1.com/content/ws/all/1fb492a9-7e56-4dca-9fa8-878548679887.svg" alt="">
            </a>
        </div>
    </div>

    <?php err_msg_alert(); ?>


    <main class="home-cards mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">

            <?php
            $conn = DB::connect("store.php", "/f1_project/views/public/index.php");
            [$num_products, $products] = DB::stmt_get_record_by_field($conn,
                "SELECT * FROM Products ORDER BY id DESC;",
                "store.php",
                "/f1_project/views/public/index.php");
            if (!$conn->close()) {
                error("500", "conn_close()", "store.php", "/f1_project/views/public/index.php");
                exit;
            }
            ?>

            <?php if ($num_products > 0) { ?>

                <!-- TODO: https://stackoverflow.com/questions/30981765/how-to-divide-table-to-show-in-pages-the-table-data-is-filled-dynamically-with -->
                <?php foreach ($products as $product) { ?>

                    <div class="col d-flex align-items-stretch">
                        <a href="product.php?id=<?php echo $product["id"]; ?>" class="text-decoration-none">
                            <div class="card bordered border-danger border-3 p-2 h-100">
                                <div class="card-img">
                                    <img src="<?php echo explode("\t", $product["img_url"])[0]; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body d-flex align-items-end p-1">
                                    <div class="w-100">
                                        <h5 class="card-title text-danger"><?php echo $product["title"]; ?></h5>
                                        <hr>
                                        <p class="card-text"><?php echo (strlen($product["description"]) < 50)? $product["description"] : (substr($product["description"], 0, 70) . " [...]"); ?></p>
                                        <div class="card-text text-decoration-none d-flex justify-content-between align-items-end pt-3">
                                            <h5 style="border-top: 2px solid red; border-right: 2px solid red; padding-right: 5px;" class="h-100 d-flex align-items-center">
                                                <?php [$int, $dec] = str2int_dec($product["price"]); ?>
                                                <strong>€ <?php echo $int . "." . $dec ?></strong>
                                            </h5>
                                            <span <?php echo get_data_id($product); ?> class="d-flex flex-row gap-2 pb-1 hover-red">
                                                <span <?php echo get_data_id($product); ?> class="btn-add-cart btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                                                    <span <?php echo get_data_id($product); ?> class="material-symbols-outlined">shopping_bag</span>
                                                    <span <?php echo get_data_id($product); ?>>Add it!</span>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php } ?>

            <?php } else { ?>
                <div class="mx-auto alert alert-no-data border-light fade show d-flex align-items-center justify-content-center mt-4 col-12" role="alert">
                    <span class="material-symbols-outlined">description</span>
                    <span class="mx-2">
                    <b>INFO</b>&nbsp;| No Data available!
                </span>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

<script src="../../../assets/js/store.js"></script>
</html>