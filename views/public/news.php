<?php

/** https://getcomposer.org/doc/00-intro.md */
/** https://copyprogramming.com/howto/php-php-get-image-by-xpath?utm_content=cmp-true */

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once ("controllers/news/news.php");
require_once ("views/partials/public/news_cards.php");
const COL_CARD = "col-3";

[$title_list, $img_list, $link_list] = f1_scrape_news(BASE_URL);
?>



<!DOCTYPE html>
<html lang="en">
      <!--xmlns="http://www.w3.org/1999/html"-->
<head>
    <title>News</title>
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
            <br
            <span class="title text-light">
                <span class="text-light h2">
                    News
                    <span class="material-symbols-outlined text-danger">download</span>
                </span>
                (provided by <a href="<?php echo end($link_list); ?>" target="_blank" class="text-info text-decoration-none">formula1.com</a>)
            </span>
            <?php echo_news_cards($title_list, $img_list, $link_list, MAX_NEWS_NEWS, COL_CARD); ?>
        </main>
    </div>
</body>
</html>