<?php if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()"); ?>
<?php require_once("auth/auth.php"); ?>
<?php require_once("utility/error_handling.php"); ?>
<?php require_once("utility/store.php"); ?>
<?php require_once ("DB/DB.php"); ?>
<?php require_once("views/partials/alert.php") ?>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php
if(!isset($_GET["id"]) || !$_GET["id"]) {
    error("500", "ID not given", "product.php", "/f1_project/views/public/store/store.php");
    exit;
}

$conn = DB::connect("product.php", "/f1_project/views/public/store/store.php");
$product = DB::get_record_by_field($conn,
    "SELECT Products.id AS 'Products.id', Products.title AS 'Products.title', Products.color AS 'Products.color', Products.size AS 'Products.size', Products.description AS 'Products.description', Products.price AS 'Products.price', Products.img_url AS 'Products.img_url', Teams.id AS 'Teams.id', Teams.name AS 'Teams.name', Teams.color_rgb_value AS 'Teams.color_rgb_value' FROM Products JOIN Teams ON Products.team_id = Teams.id WHERE Products.id = ?",
    ["i"],
    [$_GET["id"]],
    "product.php",
    "/f1_project/views/public/store/store.php")[0];
if (!$conn->close()) {
    error("500", "conn_close()", "product.php", "/f1_project/views/public/store/store.php");
    exit;
}
if (!$product) {
    error("500", "product_look_up", "product.php", "/f1_project/views/public/store/store.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title><?php echo $product["Products.title"] ?></title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/store.css">
    <link rel="stylesheet" href="/f1_project/assets/css/product.css">

    <?php include("views/partials/head.php"); ?>
</head>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("views/partials/navbar_store.php")?>

    <main class="mt-4 mx-auto p-3 row d-flex justify-content-center align-items-stretch">
        <?php if ($product["Products.img_url"]) { ?>
            <?php $img_urls = explode("\t", $product["Products.img_url"]); ?>
            <div class="col-12 col-sm-6">
                <div id="Indicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <?php if ($img_urls[1]) { ?>
                            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <?php } ?>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $img_urls[0]; ?>" class="d-block w-100 img-carousel rounded" alt="...">
                        </div>
                        <?php if ($img_urls[1]) { ?>
                            <div class="carousel-item">
                                <img src="<?php echo $img_urls[1]; ?>" class="d-block w-100 img-carousel rounded" alt="...">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#Indicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#Indicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        <?php } ?>
        <div class="col-12 col-sm-6">
            <h3><?php echo $product["Products.title"]; ?></h3>
            <hr>
                <div>

                    <?php if ($product["Products.color"]) { ?>
                        <?php
                        $str_color = "";
                        foreach (explode(";", $product["Products.color"]) as $color) {
                            $str_color .= ucfirst($color) . " ";
                        }
                        ?>
                        <label for="s-color">Color: <?php echo $str_color; ?></label>
                    <?php } ?>

                    <?php if ($img_urls != null) { ?>
                        <?php foreach ($img_urls as $img) { ?>
                            <img class="mx-3" src="<?php echo $img; ?>" height="50px" alt="">
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php if ($product["Teams.name"]) { ?>
                <label for="s-team-name" class="mt-3">Team: <?php echo $product["Teams.name"]; ?></label>
            <?php } ?>
            <?php if ($product["Products.size"]) { ?>
                <?php $size = explode(";", $product["Products.size"]); ?>
                <div class="d-flex flex-column justify-content-center flex-md-row align-md-items-center justify-content-md-start gap-md-3">
                    <div class="mt-4 d-flex justify-content-start align-items-center gap-2">
                        <label for="s-size">Size: </label>
                        <select name="s-size" id="s-size" class="form-select rounded-pill" aria-label="Select size">
                            <option value="ns" class="option_invalid" selected>Select size</option>
                            <?php
                            foreach ($size as $s) {
                                echo "<option value='$s' class='option_valid'>" . strtoupper($s). "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="select-info" class="d-none d-flex gap-2 mt-4 py-1">
                        <span class="material-symbols-outlined"></span>
                        <span class=""></span>
                    </div>
                </div>
            <?php } ?>
            <hr>
            <div class="d-flex justify-content-end gap-3">
                <?php [$int, $dec] = str2int_dec($product["Products.price"]); ?>
                <h3>€ <?php echo "$int.$dec" ?></h3>
                <div <?php echo get_data_id($product); ?> class="d-flex flex-row gap-2 pb-1 hover-red">
                    <div <?php echo get_data_id($product); ?> class="btn-add-cart btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                        <span <?php echo get_data_id($product); ?> class="material-symbols-outlined">shopping_bag</span>
                        <span <?php echo get_data_id($product); ?>>Add to cart!</span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item rounded-top">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Description
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <label><?php echo $product["Products.description"]; ?></label>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Dettagli
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <ul>
                                <li>
                                    Made in Italy
                                </li>
                                <li>
                                    Edizione speciale GP Las Vegas 2023
                                </li>
                                <li>
                                    Not for race
                                </li>
                                <li>
                                    Scudetto Ferrari
                                </li>
                                <li>
                                    Loghi sponsor
                                </li>
                                <li>
                                    Il capo è disponibile solo nella misura di Charles Leclerc (taglia S italiana)
                                </li>
                                <li>
                                    Composizione Primaria: 58% Fibra aramidica 39% Viscosa 3% Elastan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="/f1_project/assets/js/navbar.js"></script>
</html>
