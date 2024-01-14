<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once ("controllers/news/news.php");
require_once ("views/partials/public/news_cards.php");
require_once("controllers/auth/auth.php");

const COL_CARD = "col-12";

[$title_list, $img_list, $link_list] = f1_scrape_news(BASE_URL);

$json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "\\views\\partials\\public\\index_cards.json");
$json_cards_data = json_decode($json, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
</head>

<body class="bg-dark">
<div class="container-fluid">

    <!-- Nav -->
    <?php include ("views/partials/navbar.php");?>

    <main>
        <!-- Showcase -->
        <div id="Indicators" class="carousel slide " data-bs-ride="carousel">
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
                    <img src="/f1_project/assets/images/wp12074925-mercedes-formula-1-4k-wallpapers.jpg" class="d-block w-100 img-carousel rounded" alt="F1 Mercedes">
                </div>
                <div class="carousel-item">
                    <img src="/f1_project/assets/images/wp12405472-ferrari-f1-4k-wallpapers.jpg" class="d-block w-100 img-carousel rounded" alt="F1 Ferrari">
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

        <!-- Home cards -->
        <section class="home-cards row d-flex justify-content-around gap-5 gap-md-0">

            <!-- News -->
            <div style="border-radius: 10px; background: rgba(87, 87, 87, .6); " class="col-12 order-2 col-md-4 order-md-1 d-flex justify-content-center flex-column">
                <span class="title text-light pt-2">
                    <span class="text-light h2">
                        News
                        <span class="material-symbols-outlined text-danger">download</span>
                    </span>
                    (provided by <a href="https://www.formula1.com/en/latest/all" target="_blank" class="text-info text-decoration-none">formula1.com</a>)
                </span>
                <?php echo_news_cards($title_list, $img_list, $link_list, MAX_NEWS_INDEX, COL_CARD); ?>
            </div>

            <!-- Browse our site -->
            <div class="col-12 col-md-8">
                <h2 class="title text-light d-flex justify-content-center align-items-center gap-2">Browse our site
                    <span class="material-symbols-outlined text-danger">travel_explore</span>
                </h2>
                <br>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-4">

                    <?php foreach ($json_cards_data as $card) { ?>
                        <div class="col d-flex align-items-stretch">
                            <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                                <div class="card-img">
                                    <img src="<?php echo $card["img_url"]; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body d-flex align-items-end">
                                    <div class="w-100">
                                        <h5 class="card-title text-danger"><?php echo $card["title"]; ?></h5>
                                        <hr>
                                        <p class="card-text"><?php echo $card["text"]; ?></p>
                                        <p class="card-text">
                                            <a href="<?php echo $card["link"]; ?>" class="card-link text-decoration-none d-flex flex-row justify-content-end">
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
                    <?php } ?>

                </div>
            </div>

        </section>

    </main>
</div>
</body>
</html>