<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/index_style.css">
    <link rel="stylesheet" href="../../../assets/css/product.css">

    <?php include("../../partials/head.php"); ?>
    <?php require_once("../../../auth/auth.php") ?>

    <?php require_once("../../../utility/error_handling.php"); ?>
    <?php require_once ("../../../utility/store.php") ?>
    <?php require_once ("../../../DB/DB.php"); ?>
    <?php require_once("../../partials/alert.php") ?>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("../../partials/navbar_store.php")?>


    <?php
    if(!isset($_GET["id"]) || !$_GET["id"]) {
        error("500", "ID not given", "product.php", "/f1_project/views/public/store.php");
        exit;
    }

    $conn = DB::connect("product.php", "/f1_project/views/public/store.php");
    $product = DB::get_record_by_field($conn,
        "SELECT * FROM Products WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "product.php",
        "/f1_project/views/public/store.php")[0];
    if (!$conn->close()) {
        error("500", "conn_close()", "product.php", "/f1_project/views/public/store.php");
        exit;
    }
    if (!$product) {
        error("500", "product_look_up", "product.php", "/f1_project/views/public/store.php");
        exit;
    }
    ?>


    <main class="mt-4 mx-auto p-3 row d-flex justify-content-center align-items-stretch">
        <div class="col-12 col-sm-6">
            <div id="Indicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#Indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?php echo $product["img_url"]; ?>" class="d-block w-100 img-carousel rounded" alt="...">
                    </div>
                    <!-- TODO: gestione più foto -->
                    <!-- <div class="carousel-item">
                        <img src="https://store.ferrari.com/product_image/1647597333252950/R/w1080.jpg" class="d-block w-100 img-carousel rounded" alt="...">
                    </div> -->
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
        <div class="col-12 col-sm-6">
            <h3><?php echo $product["title"]; ?></h3>
            <hr>
            <?php if ($product["color"]) { ?>
                <div>
                    <label for="s-color">Color: <?php echo $product["color"]; ?></label>
                    <img class="mx-3" src="<?php echo $product["img_url"]; ?>" height="50px" alt="">
                </div>
            <?php } ?>
            <?php if ($product["size"]) { ?>
                <?php $size = explode(";", $product["size"]); ?>
                <div>
                    <div class="mt-4 d-flex justify-content-start align-items-center gap-2">
                        <label for="s-size">Size: </label>
                        <select name="s-size" id="s-size" class="form-select rounded-pill" aria-label="Select size">
                            <option value="ns" class="option_invalid" selected disabled>Select the size</option>
                            <?php
                            foreach ($size as $s) {
                                echo "<option value='$s' class='option_valid'>" . strtoupper($s). "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <hr>
            <div class="d-flex justify-content-end gap-3">
                <?php [$int, $dec] = str2int_dec($product["price"]); ?>
                <h3>€ <?php echo "$int.$dec" ?></h3>
                <div class="d-flex flex-row gap-2 pb-1 hover-red">
                    <div id="btn-add-cart" class="btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        <span>Add to cart!</span>
                    </div>
                </div>
            </div>

            <hr>


            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item rounded-top">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Descrizione
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <label><?php echo $product["description"]; ?></label>
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



    </main>
</body>


<script>
    $("#btn-add-cart").click(() => {
        let curr_cart = JSON.parse(localStorage.getItem("cart"))
        if (!curr_cart) curr_cart = []
        curr_cart.push({
            "id": 1,
            "name": "sottotuta",
            "size": "M",
            "color": "multicolor",
            "price": 500
        })
        console.log(curr_cart)
        localStorage.setItem("cart", JSON.stringify(curr_cart))

        $("#cart-notification-dot").text(curr_cart.length)
    })
</script>
</html>
