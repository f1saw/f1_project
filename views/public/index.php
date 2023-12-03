<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <?php include("../partials/head.php"); ?>

    <!-- <link rel="stylesheet" href="../../assets/css/index_style.css"> -->

    <?php require_once("../../auth/auth.php") ?>

    <style>
        * {
            color: white;
        }

        hr {
            border-top: 3px solid red;
        }

        .img-carousel{
            aspect-ratio: 5.3/2;
            object-fit: cover;
        }

        .title{
            text-align: center;
        }

        .card img {
            transition: all ease-in-out 1s;
        }

        .card-img {
            overflow: hidden;
        }

        .card:hover img {
            transform: scale(1.1);
        }

        .home-cards * {
            color: rgb(33,37,41);
        }
        #navbar {
            background-color: transparent;
        }

        #navbar-logo {
            width: 70px;
            height: 70px;
            background-image: url('/f1_project/assets/images/F1.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .my_outline_animation {
            border: none;
            position: relative;
            transition: all ease-in-out .2s;
        }

        .my_outline_animation::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            left: 50%;
            bottom: 0;
            background-color: red;
            transition: all ease-in-out .2s;
        }

        .my_outline_animation:hover::after {
            width: 100%;
            left: 0;
        }

        .hover-red:hover .material-symbols-outlined {
            color: red;
        }

        main {
            max-width: 1300px;
            margin: auto;
        }

    </style>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<body>
<div class="container-fluid bg-dark">

    <!-- Nav -->
    <nav id="navbar" class="w-100 navbar navbar-expand-lg mb-3 mb-lg-0">
        <div class="container-fluid px-4">
            <a id="navbar-logo" class="navbar-brand px-5" href="/f1_project/views/public/index.php"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse d-lg-flex justify-content-lg-between align-items-center" id="navbarNav">
                <form class="d-none d-lg-flex" role="search" name="search_bar">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                </form>

                <ul class="navbar-nav d-flex flex-column align-items-end gap-4 flex-lg-row justify-content-lg-end gap-lg-5">
                    <div class="d-flex flex-column align-items-end gap-4 flex-lg-row gap-lg-4 mt-4 mt-lg-0">
                        <li class="nav-item d-flex align-items-end">
                            <a href="#" class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2">
                                <span class="material-symbols-outlined">shopping_bag</span>
                                <span>Store</span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-end">
                            <a href="#" class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2">
                                <span class="material-symbols-outlined">sports_score</span>
                                <span>Circuits</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li> -->
                    </div>




                    <div class="d-flex gap-3">
                        <?php
                        [$login_allowed, $user] = check_cookie();
                        if (!check_user_auth($user)) {
                            set_session($user);?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-danger text-light px-4 d-flex gap-2" href="login_form.php">
                                    <span class="material-symbols-outlined">login</span>
                                    <span>Login</span>
                                </a>
                            </li>
                            <li class="nav-item my_outline_animation">
                                <a class="nav-link text-light d-flex gap-2" href="registration_form.php">
                                    <span class="material-symbols-outlined">how_to_reg</span>
                                    <span>Registration</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="#">

                                    <?php if(isset($_SESSION["img_url"]) && $_SESSION["img_url"] != NULL){ ?>
                                        <img src="<?php echo $_SESSION["img_url"]; ?>" alt="Profile">
                                    <?php } else{ ?>
                                        <img style="border-radius: 50%; width: 24px; height: 24px;" src="../../assets/images/foto-profilo.jpg" alt="Profile">
                                    <?php }?>

                                    <span>My profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="../private/logout.php">
                                    <span class="material-symbols-outlined">logout</span>
                                    <span>Logout</span>
                                </a>
                            </li>
                        <?php } if (check_admin_auth($user)){ ?>
                            <li class="nav-item">
                                <a class="my_outline_animation text-decoration-none hover-red d-flex align-items-end pb-2 gap-2" href="#">
                                    <span class="material-symbols-outlined">table_rows</span>
                                    <span>Table users</span>
                                </a>
                            </li>
                        <?php } ?>
                    </div>


                    <!--Implementare scomparsa con js-->
                    <!-- <form class="d-flex d-lg-none" role="search">
                        <input class="form-control me-2" style="width: 100px;height: 30px" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success d-flex align-items-center justify-content-center" style="width: 50px;height: 30px; overflow:hidden; text-overflow: ellipsis;" type="submit">Go</button>
                    </form> -->

                    <form class="d-flex flex-row d-lg-none" role="search" name="search_bar">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-danger" type="submit">Search</button>
                    </form>
                </ul>

            </div>


            <!-- <div class="d-inline d-lg-none">
                <form class="d-none d-lg-flex" role="search" name="search_bar">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Search</button>
                </form>
            </div> -->
        </div>
    </nav>



    <!-- <h1 class="title">Welcome!</h1> -->

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
