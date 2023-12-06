<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/index_style.css">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php") ?>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <?php include ("../partials/navbar.php")?>


    <main>
        <!-- Showcase -->
        <div id="Indicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#Indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#Indicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://wallpapercave.com/dwp2x/wp11269245.jpg" class="d-block w-100 img-carousel rounded" alt="F1 2022">
                </div>
                <div class="carousel-item">
                    <img src="../../assets/images/wp12074925-mercedes-formula-1-4k-wallpapers.jpg" class="d-block w-100 img-carousel rounded" alt="F1 Mercedes">
                </div>
                <div class="carousel-item">
                    <img src="../../assets/images/wp12405472-ferrari-f1-4k-wallpapers.jpg" class="d-block w-100 img-carousel rounded" alt="F1 Ferrari">
                </div>
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

        <br>
        <h2 class="title">Browse our site!</h2>
        <br>

        <!-- Home cards 1 -->
        <section class="home-cards">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                <div class="col d-flex align-items-stretch">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img">
                            <img src="https://media.formula1.com/image/upload/content/dam/fom-website/2018-redesign-assets/Circuit%20maps%2016x9/USA_Circuit.png" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <h5 class="card-title text-danger">Circuits</h5>
                                <hr>
                                <p class="card-text">In this section you can see <strong>all</strong> the characteristic F1 circuits.</p>
                                <p class="card-text">
                                    <a href="#" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                        <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                            <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                            Check it out!
                                            <span class="material-symbols-outlined">sports_score</span>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col d-flex align-items-stretch">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img">
                            <img src="https://i.ytimg.com/vi/jKZKCl_GEgY/maxresdefault.jpg" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <h5 class="card-title text-danger">FIA Regulations <br> Formula One World Championship</h5>
                                <hr>
                                <p class="card-text">Have fun in reading these <strong>short</strong> docs <strong>:P</strong></p>
                                <p class="card-text">
                                    <a href="https://www.fia.com/regulation/category/110" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                        <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                            <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                            Check it out!
                                            <span class="material-symbols-outlined">sports_score</span>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col d-flex align-items-stretch">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img">
                            <img src="https://hoteldelaville.com/wp-content/uploads/2021/06/gran-premio-di-monza-informazioni-1000x634.jpg" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <h5 class="card-title text-danger">Statistics</h5>
                                <hr>
                                <p class="card-text"><strong>Data</strong> lover? This section is for you!</p>
                                <p class="card-text">
                                    <a href="#" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                        <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                            <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                            Check it out!
                                            <span class="material-symbols-outlined">sports_score</span>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col d-flex align-items-stretch">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img">
                            <!-- <img src="https://www.f1-fansite.com/wp-content/uploads/2023/11/230070-scuderia-ferrari-abu-dhabi-gp-2023-race_2ca9a370-0909-4cca-adae-9dbf3c91638f.jpg" class="card-img-top" alt="..."> -->
                            <img src="https://www.sportinglad.com/wp-content/uploads/2023/08/ezgif.com-gif-maker.webp" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <h5 class="card-title text-danger">Drivers</h5>
                                <hr>
                                <p class="card-text">Discover the secrets of your favorite drivers <strong>:)</strong></p>
                                <p class="card-text">
                                    <a href="#" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                        <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                            <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                            Check it out!
                                            <span class="material-symbols-outlined">sports_score</span>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col d-flex align-items-stretch">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img d-flex justify-content-center">
                            <!-- <img src="https://www.f1-fansite.com/wp-content/uploads/2023/11/230070-scuderia-ferrari-abu-dhabi-gp-2023-race_2ca9a370-0909-4cca-adae-9dbf3c91638f.jpg" class="card-img-top" alt="..."> -->
                            <img style="width: 250px;" src="https://grandprixstore.co.za/wp-content/uploads/2023/05/Grand-Prix-Store-Shop-Ferrari.jpg" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <h5 class="card-title text-danger">Store</h5>
                                <hr>
                                <p class="card-text">Buy <strong>official</strong> merchandise</p>
                                <p class="card-text">
                                    <a href="#" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                        <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                            <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                            Check it out!
                                            <span class="material-symbols-outlined">sports_score</span>
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
