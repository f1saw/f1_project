<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/index_style.css">

    <?php include("../../partials/head.php"); ?>
    <?php require_once("../../../auth/auth.php") ?>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("../../partials/navbar.php")?>


    <div class="w-100 d-flex flex-column gap-3">
        <h3 class="d-flex justify-content-center">
            Shop by Team
        </h3>
        <style>
            #shop-by-team {
                background-color: rgba(231,227,224,.3);
            }
            #shop-by-team * {
                width: 60px;
            }
        </style>
        <div id="shop-by-team" class="row d-flex justify-content-center align-items-center gap-5 p-1">
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
                <img src="https://f1store2.formula1.com/content/ws/all/1fb492a9-7e56-4dca-9fa8-878548679887.svg" alt="">
            </a>
        </div>
    </div>


    <main class="home-cards mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">


            <div class="col d-flex align-items-stretch">
                <a href="product.php?id="<?php echo "ITEM_ID";?> class="text-decoration-none">
                    <div class="card bordered border-danger border-3 p-2 h-100">
                        <div class="card-img">
                            <img src="https://images.footballfanatics.com/scuderia-ferrari/scuderia-ferrari-2023-team-t-shirt_ss4_p-13368608+u-ya0zcr5gjt4kzyrcb08m+v-f28b0bcee21c492bbbd3d4f328095725.jpg?_hv=2&w=340" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end p-1">
                            <div class="w-100">
                                <h5 class="card-title text-danger">ITEM_NAME</h5>
                                <hr>
                                <p class="card-text">ITEM_DESC</p>
                                <div class="card-text text-decoration-none d-flex justify-content-between align-items-end pt-3">
                                    <h5 style="border-top: 2px solid red; border-right: 2px solid red; padding-right: 5px;" class="h-100 d-flex align-items-center">
                                        <strong>€ 50.00</strong>
                                    </h5>
                                    <span class="d-flex flex-row gap-2 pb-1 hover-red">

                                        <style>
                                            .btn-reverse-color * {
                                                color: white;
                                            }

                                            .btn-reverse-color:hover {
                                                background-color: white;
                                            }
                                            .btn-reverse-color:hover * {
                                                color: red;
                                            }
                                        </style>
                                        <span class="btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                                            <span class="material-symbols-outlined">shopping_bag</span>
                                            <span>Add it!</span>
                                        </span>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col d-flex align-items-stretch">
                <a href="product.php" class="text-decoration-none">
                    <div class="card bordered border-danger border-3 p-2 h-100">
                        <div class="card-img">
                            <img src="https://images.footballfanatics.com/scuderia-ferrari/scuderia-ferrari-2023-team-softshell-jacket_ss4_p-13368388+u-1697ehkh6odvy4fw2s3h+v-0ca11877b48b48afa306d16c0a65476d.jpg?_hv=2&w=340" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end p-1">
                            <div class="w-100">
                                <h5 class="card-title text-danger">ITEM_NAME</h5>
                                <hr>
                                <p class="card-text">ITEM_DESC</p>
                                <div class="card-text text-decoration-none d-flex justify-content-between align-items-end pt-3">
                                    <h5 style="border-top: 2px solid red; border-right: 2px solid red; padding-right: 5px;" class="h-100 d-flex align-items-center">
                                        <strong>€ 50.00</strong>
                                    </h5>
                                    <span class="d-flex flex-row gap-2 pb-1 hover-red">

                                        <style>
                                            .btn-reverse-color * {
                                                color: white;
                                            }

                                            .btn-reverse-color:hover {
                                                background-color: white;
                                            }
                                            .btn-reverse-color:hover * {
                                                color: red;
                                            }
                                        </style>
                                        <span class="btn-reverse-color btn btn-danger d-flex justify-content-center align-items-center gap-2">
                                            <span class="material-symbols-outlined">shopping_bag</span>
                                            <span>Add it!</span>
                                        </span>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>







        </div>
    </main>

</body>
</html>
