<!DOCTYPE html>
<html lang="en">
<head>
    <title>home</title>
    <link rel='stylesheet'
          href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    <link rel="stylesheet" href="style/index_style.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous">
    </script>
    <meta charset="UTF-8">
    <?php require_once("auth/auth.php")?>
</head>
<body>
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<div class="container">
    <!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid d-flex justify-content-end">
            <img class="img_logo" src="https://www.dinamikamente.net/wp-content/uploads/2017/11/nuovo-logo-formula-1.png" width="35" height="35"
                 alt="Logo f1">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Circuit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>

                        <?php
                        [$login_allowed, $user] = check_cookie();
                        if (!check_user_auth($user)) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="views/public/login_form.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="views/public/registration_form.php">Registration</a>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">My profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="views/private/logout.php">Logout</a>
                            </li>
                            <?php
                        }
                        if (check_admin_auth($user)){
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Table users</a>
                            </li>
                            <?php
                        }
                        ?>

                        <li>
                            <a href="#"><img src=https://static.vecteezy.com/ti/vettori-gratis/p1/4568682-shop-open-line-icon-vettoriale.jpg" width="25" height="25"
                                             alt="Logo shop" style="position: relative; top: 5px"></a>
                        </li>
                        <!--Implementare scomparsa con js-->
                        <form class="d-flex d-lg-none" role="search">
                            <input class="form-control me-2" style="width: 100px;height: 30px" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success d-flex align-items-center justify-content-center" style="width: 50px;height: 30px; overflow:hidden; text-overflow: ellipsis;" type="submit">Go</button>
                        </form>
                    </ul>
                    <form class="d-none d-lg-flex" style="position: absolute; right:0;" role="search" name="search_bar">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-danger" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <h1 class="title">Welcome!</h1>

    <!-- Showcase -->
    <div id="Indicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#Indicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://wallpapercave.com/dwp2x/wp11269245.jpg" class="d-block w-100 img-carousel" alt="F1 2022">
            </div>
            <div class="carousel-item">
                <img src="images/wp12074925-mercedes-formula-1-4k-wallpapers.jpg" class="d-block w-100 img-carousel" alt="F1 Mercedes">
            </div>
            <div class="carousel-item">
                <img src="images/wp12405472-ferrari-f1-4k-wallpapers.jpg" class="d-block w-100 img-carousel" alt="F1 Ferrari">
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
        <div>
            <img class="img-home-cards" src="https://media.formula1.com/image/upload/content/dam/fom-website/2018-redesign-assets/Circuit%20maps%2016x9/USA_Circuit.png" alt="">
            <h3>Circuit</h3>
            <p>
                In this section you can see all the characteristic F1 circuits.
            </p>
            <a href="#">Learn More <i class="fas fa-chevron-right"></i></a>
        </div>
        <div>
            <img class="img-home-cards" src="https://formu1a.uno/wp-content/uploads/2022/12/formu1a-2022-vs-2023-front-floor.jpg" alt="" />
            <h3>Regulation</h3>
            <p>
                If you are a new fan discover the rules of F1!
            </p>
            <a href="#">Learn More <i class="fas fa-chevron-right"></i></a>
        </div>
        <div>
            <img class="img-home-cards" src="https://hoteldelaville.com/wp-content/uploads/2021/06/gran-premio-di-monza-informazioni-1000x634.jpg" alt="" />
            <h3>Information</h3>
            <p>
                If you are looking for the best times per circuit, this is the section for you!.
            </p>
            <a href="#">Learn More <i class="fas fa-chevron-right"></i></a>
        </div>
        <div>
            <img class="img-home-cards" src="https://cdn-autosprint.corrieredellosport.it/img/1146/645/2022/11/22/122523534-4bb76434-2355-45ab-888a-c2a3bdea3b96.jpg" alt="" />
            <h3>Pilots</h3>
            <p>
                Here you can consult the drivers who have raced in F1 since the first season
            </p>
            <a href="#">Learn More <i class="fas fa-chevron-right"></i></a>
        </div>
    </section>

</body>
</html>
