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

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/news.css">

    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php") ?>
</head>

<body class="bg-dark">
    <div class="container-fluid">

        <!-- Nav -->
        <?php include ("views/partials/navbar.php");?>

        <main>
            <h2 class="title">News</h2>
            <br>
            <div class="row">
                <?php for ($i = 0; $i < count($title_list); $i++) { ?>
                    <div class="col-3 d-flex align-items-stretch py-3">
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
        </main>
    </div>
</body>
</html>
