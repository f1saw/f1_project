<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("auth/auth.php");
require_once("utility/error_handling.php");
require_once("views/partials/alert.php");
require_once ("utility/store.php");
require_once ("DB/DB.php");


/** GET TEAMS */
$conn = DB::connect("store.php", "/f1_project/views/public/index.php");
[$num_teams, $teams] = DB::stmt_get_record_by_field($conn,
    "SELECT * FROM Teams;",
    "store.php",
    "/f1_project/views/public/index.php");

/** GET Products (eventually filtered by team) */
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

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Store</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store.css">
    <link rel="stylesheet" href="/f1_project/assets/css/loading.css">
</head>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("views/partials/navbar_store.php")?>



    <div class="w-100 d-flex flex-column gap-3">
        <h3 class="d-flex justify-content-center">
            Shop by Team
        </h3>
        <div id="shop-by-team" class="row d-flex justify-content-center align-items-center gap-5 p-3">
            <?php foreach($teams as $team) { ?>
                <a href="?team=<?php echo $team["id"]?>">
                    <img src="<?php echo $team["logo_url"]; ?>" alt="<?php echo $team["name"]; ?>">
                </a>
            <?php } ?>
        </div>
    </div>

    <?php err_msg_alert(); ?>

    <!-- Loader -->
    <div class="mx-auto lds-ring-container py-2">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>

    <main class="home-cards mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">

            <?php if ($num_products > 0) { ?>

                <!-- TODO: https://stackoverflow.com/questions/30981765/how-to-divide-table-to-show-in-pages-the-table-data-is-filled-dynamically-with -->
                <?php $i = 0; ?>
                <?php foreach ($products as $product) { ?>

                    <div class="d-none col d-flex align-items-stretch product" id="product-<?php echo $i; ?>">
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
                                            <span <?php echo get_data_id($product); ?> id="span-add-it-<?php echo $product["Products.id"]; ?>" class="btn-modal d-flex flex-row gap-2 pb-1 hover-red">
                                                <button <?php echo get_data_id($product); ?> data-bs-toggle="modal" data-bs-target="#modal-<?php echo $product["Products.id"]; ?>" class="btn-add-cart btn-modal btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                                                    <span <?php echo get_data_id($product); ?> class="btn-modal material-symbols-outlined">shopping_bag</span>
                                                    <span <?php echo get_data_id($product); ?> class="btn-modal">Add it!</span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <!-- Modal (to choose size) -->
                    <div class="modal fade" id="modal-<?php echo $product["Products.id"]; ?>" tabindex="-1" aria-labelledby="modal-<?php echo $product["Products.id"]; ?>Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select size</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php $size = explode(";", $product["Products.size"]); ?>
                                    <select id="s-size-<?php echo $product["Products.id"]; ?>" class="form-select rounded-pill" aria-label="Select size">
                                        <option value="ns" class="option_invalid" selected>Select size</option>
                                        <?php
                                        foreach ($size as $s) {
                                            echo "<option value='$s' class='option_valid'>" . strtoupper($s). "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary my_close" id="close-modal-<?php echo $product["Products.id"]; ?>" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger btn-reverse-color my_confirm" id="confirm-modal-<?php echo $product["Products.id"]; ?>" data-bs-dismiss="modal">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                $i++;
                }
                ?>

            <?php } else { ?>
                <div class="mx-auto alert alert-no-data border-light fade show d-flex align-items-center justify-content-center mt-4 col-12" role="alert">
                    <span class="material-symbols-outlined">description</span>
                    <span class="mx-2">
                        <b>INFO</b>&nbsp;| No Data available!
                    </span>
                </div>
            <?php } ?>

        </div>

        <div class="page-selector d-flex justify-content-center align-items-center gap-3 py-5">
            <button class="btn btn-navigate-page d-flex justify-content-center align-items-center" id="prev-page">
                <span class="material-symbols-outlined text-danger">fast_rewind</span>
            </button>
            <button class="btn btn-outline-danger btn-navigate-page" id="curr-page">1</button>
            <button class="btn btn-navigate-page d-flex justify-content-center align-items-center" id="next-page">
                <span class="material-symbols-outlined text-danger">fast_forward</span>
            </button>
        </div>
    </main>
</body>

<script src="/f1_project/assets/js/navbar.js"></script>
<script src="/f1_project/assets/js/store.js"></script>
</html>