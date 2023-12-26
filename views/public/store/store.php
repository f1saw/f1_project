<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Store</title>
    <meta charset="UTF-8">

    <?php
    if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
        error("500", "set_include_path()");
    ?>

    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php") ?>

    <?php require_once("utility/error_handling.php"); ?>
    <?php require_once("views/partials/alert.php") ?>
    <?php require_once ("utility/store.php") ?>
    <?php require_once ("DB/DB.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store.css">

</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("views/partials/navbar_store.php")?>

    <div class="w-100 d-flex flex-column gap-3">
        <h3 class="d-flex justify-content-center">
            Shop by Team
        </h3>
        <?php
        $conn = DB::connect("store.php", "/f1_project/views/public/index.php");
        [$num_teams, $teams] = DB::stmt_get_record_by_field($conn,
            "SELECT * FROM Teams;",
            "store.php",
            "/f1_project/views/public/index.php");
        ?>
        <div id="shop-by-team" class="row d-flex justify-content-center align-items-center gap-5 p-3">
            <?php foreach($teams as $team) { ?>
                <a href="?team=<?php echo $team["id"]?>">
                    <img src="<?php echo $team["logo_url"]; ?>" alt="<?php echo $team["name"]; ?>">
                </a>
            <?php } ?>
        </div>
    </div>

    <?php err_msg_alert(); ?>


    <main class="home-cards mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">

            <?php
            $team_filter = (isset($_GET["team"]) && $_GET["team"])? ("WHERE team_id = " . $_GET["team"]):"";
            [$num_products, $products] = DB::stmt_get_record_by_field($conn,
                "SELECT 
                            Products.id AS 'Products.id', Products.title AS 'Products.title', Products.color AS 'Products.color', Products.size AS 'Products.size', Products.description AS 'Products.description', Products.price AS 'Products.price', Products.img_url AS 'Products.img_url', 
                            Teams.id AS 'Teams.id', Teams.name AS 'Teams.name', Teams.color_rgb_value AS 'Teams.color_rgb_value' 
                        FROM Products JOIN Teams ON Products.team_id = Teams.id 
                        $team_filter 
                        ORDER BY Products.id DESC;",
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
                        <a href="product.php?id=<?php echo $product["Products.id"]; ?>" class="text-decoration-none">
                            <div class="card bordered border-danger border-3 p-2 h-100">
                                <div class="card-img">
                                    <img src="<?php echo explode("\t", $product["Products.img_url"])[0]; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body d-flex align-items-end p-1">
                                    <div class="w-100">
                                        <h5 class="card-title text-danger"><?php echo $product["Products.title"]; ?></h5>
                                        <hr>
                                        <p class="card-text"><?php echo (strlen($product["Products.description"]) < 50)? $product["Products.description"] : (substr($product["Products.description"], 0, 70) . " [...]"); ?></p>
                                        <div class="card-text text-decoration-none d-flex justify-content-between align-items-end pt-3">
                                            <h5 style="border-top: 2px solid red; border-right: 2px solid red; padding-right: 5px;" class="h-100 d-flex align-items-center">
                                                <?php [$int, $dec] = str2int_dec($product["Products.price"]); ?>
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

<script src="/f1_project/assets/js/navbar.js"></script>
</html>