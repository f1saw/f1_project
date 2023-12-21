<?php

/** https://getcomposer.org/doc/00-intro.md */
/** https://copyprogramming.com/howto/php-php-get-image-by-xpath?utm_content=cmp-true */
/*
    composer init — require=”php >=7.4" — no-interaction
    composer update
*/

if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
const BASE_URL = "https://www.formula1.com";

function f1_scrape_news($base_url): array {

    $title_list = [];
    $img_list = [];
    $link_list = [];

    $article = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($article);
    $xpath = new DOMXPath($html);


    $node_list = $xpath->query('//picture[@class="f1-cc--photo"]//source');
    for ($i=1; $i<15; $i += 2) {
        $link = $node_list->item($i)->getAttribute("data-srcset");

        $array = explode(",", $link);
        $link = end($array);
        $link = explode(" ", $link)[1];

        $img_list[] = $link;
    }
    echo $img_list[3] . "<br><br>";


    $node_list = $xpath->query('//div[@class="f1-homepage--hero"]//div[@class="f1-cc--caption"]');
    foreach ($node_list as $n) {
        $title = $n->nodeValue;
        $title = preg_replace("/\s+/", ";", $title, 2);
        $title = explode(";", $title);
        $title = $title[1] . ";" . $title[2];
        $title_list[] = $title;
    }
    echo $title_list[3] . "<br><br>";


    $node_list = $xpath->query('//div[@class="f1-homepage--hero"]//a');
    foreach ($node_list as $n) {
        $link = $base_url . $n->getAttribute("href");
        $link_list[] = $link;
    }
    echo $link_list[3] . "<br><br>";

    return [$title_list, $img_list, $link_list];
}



[$title_list, $img_list, $link_list] = f1_scrape_news(BASE_URL);
