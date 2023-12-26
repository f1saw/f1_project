<?php

/** https://getcomposer.org/doc/00-intro.md */
/** https://copyprogramming.com/howto/php-php-get-image-by-xpath?utm_content=cmp-true */

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
const BASE_URL = "https://www.formula1.com";

function f1_scrape_news($base_url): array {

    // Init arrays of interest
    $title_list = [];
    $img_list = [];
    $link_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);


    $node_list = $xpath->query('//picture[@class="f1-cc--photo"]//source');
    // Increasing by 2 each time because otherwise there would have been duplicates
    // In this situation I obtain 7 news elements
    for ($i=1; $i<15; $i += 2) {
        $link = $node_list->item($i)->getAttribute("data-srcset");

        // Explode needed because there are multiple images in data-srcset attribute
        // I want the last of them (better resolution)
        $array = explode(",", $link);
        $link = end($array);
        // Instructions needed because the original string is "{img_url} 2x"
        // and "2x" is not relevant, so I can split by blank spaces and obtain "{img_url}"
        $link = explode(" ", $link)[1];

        // Append in array
        $img_list[] = $link;
    }
    // echo $img_list[1] . "<br><br>";


    $node_list = $xpath->query('//div[@class="f1-homepage--hero"]//div[@class="f1-cc--caption"]');
    foreach ($node_list as $n) {
        $title = $n->nodeValue;
        /*
        Replace blank spaces in the read string, the limit of the replacements is just 2
            - Limit 2 imposed to obtain this situation (not affect the title)
                "News {title}" => ";News;{title}"
        */
        $title = preg_replace("/\s+/", ";", $title, 2);
        $title = explode(";", $title);
        /*
        Case analysis: "Feature;F1 Unlocked {text}"
            - index 2 to identify "F1 Unlocked {text}"
            - if there is "F1 Unlocked" then I sign it in a cell called title[3], otherwise it will be null
        */
        if (str_contains($title[2], "F1 Unlocked")) {
            $title[2] = preg_replace("/F1 Unlocked/", "", $title[2]);
            $title[3] = "F1 Unlocked";
        } else {
            $title[3] = null;
        }
        // example: ["News", "F1 Unlocked", "{title}"]
        // or: ["Feature", null, "{title}"]
        $title = [$title[1], $title[2], $title[3]];
        $title_list[] = $title;
    }
    // echo $title_list[1] . "<br><br>";


    $node_list = $xpath->query('//div[@class="f1-homepage--hero"]//a');
    foreach ($node_list as $n) {
        $link = $base_url . $n->getAttribute("href");
        $link_list[] = $link;
    }
    // echo $link_list[1] . "<br><br>";

    return [$title_list, $img_list, $link_list];
}

[$title_list, $img_list, $link_list] = f1_scrape_news(BASE_URL);
?>

<!DOCTYPE html>
<html lang="en">
<!--xmlns="http://www.w3.org/1999/html"-->
<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/index_style.css">

    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php") ?>
</head>

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

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
        <!-- Home cards 1 -->
        <section class="home-cards row d-flex justify-content-around gap-5 gap-md-0">
            <div style="border-radius: 10px; background: rgba(87, 87, 87, .6); " class="col-12 order-2 col-md-4 order-md-1 d-flex justify-content-center flex-column">
                <span class="title text-light">
                    <span class="text-light h2">
                        News
                        <span class="material-symbols-outlined text-danger">download</span>
                    </span>
                    (provided by <a href="<?php echo end($link_list); ?>" target="_blank" class="text-info text-decoration-none">formula1.com</a>)
                </span>

                <div class="row">
                    <?php for ($i = 0; $i < min(count($title_list), 4); $i++) { ?>
                        <div class="col-12 d-flex align-items-stretch py-3">
                            <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                                <div class="card-img">
                                    <img src="<?php echo $img_list[$i] ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body d-flex align-items-end">
                                    <div class="w-100">
                                        <h6 class="card-title text-danger"><?php echo $title_list[$i][1]; ?></h6>
                                        <hr>
                                        <p class="card-text d-flex justify-content-between">
                                            <label>
                                                <strong><?php echo $title_list[$i][0] ?></strong>
                                                <?php echo $title_list[$i][2]?? "" ?>
                                            </label>
                                            <a href="<?php echo $link_list[$i] ?>" class="card-link text-decoration-none d-flex flex-row justify-content-end">
                                            <span class="my_outline_animation d-flex flex-row gap-2 pb-1 hover-red">
                                                <span class="material-symbols-outlined">keyboard_double_arrow_right</span>
                                                Go
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
            <div class="col-12 col-md-8">
                <h2 class="title text-light d-flex justify-content-center align-items-center gap-2">Browse our site
                    <span class="material-symbols-outlined text-danger">travel_explore</span>
                </h2>
                <br>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-4">
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
                                <img src="https://cdn-5.motorsport.com/images/amp/0qXjNlQ6/s6/charles-leclerc-ferrari-carlos.jpg" class="card-img-top" alt="...">
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
            </div>
        </section>
    </main>
</div>
</body>
</html>