<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

const BASE_URL = "https://www.formula1.com/en/drivers.html";

function f1_scrape_drivers($base_url): array {

    // Init arrays of interest
    $team_list = [];
    $img_list = [];
    $number_list = [];
    $name_list = [];
    $lastname_list = [];
    $flag_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get TEAMS
    $node_list = $xpath->query('//div[@class="listing-item--team f1--xxs f1-color--gray5"]');
    foreach ($node_list as $n) {
        $team = $n->nodeValue;

        $team = preg_replace("/\s+/", ";", $team, 2);
        $team = explode(";", $team);

        $team_list[] = $team;
    }

    // Get NAMES
    $node_list = $xpath->query('//span[@class="d-block f1--xxs f1-color--carbonBlack"]');
    foreach ($node_list as $n) {
        $name = $n->nodeValue;

        $name_list[] = $name;
    }

    // Get LAST NAMES
    $node_list = $xpath->query('//span[@class="d-block f1-bold--s f1-color--carbonBlack"]');
    foreach ($node_list as $n) {
        $lastname = $n->nodeValue;

        $lastname_list[] = $lastname;
    }

    // Get IMGS
    $node_list = $xpath->query('//picture[@class="listing-item--photo"]//img');
    for ($i=0; $i<$node_list->count(); ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");
        $img_list[] = $link;
    }

    // Get NUMBERS
    $node_list = $xpath->query('//picture[@class="listing-item--number"]//img');
    for ($i=0; $i<$node_list->count(); ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");
        $number_list[] = $link;
    }

    // Get FLAGS
    $node_list = $xpath->query('//picture[@class="coutnry-flag--photo"]//img');
    for ($i=0; $i<$node_list->count(); ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");
        $flag_list[] = $link;
    }

    // Get URLs
    $url_list = [];
    $node_list = $xpath->query('//div[@class="col-12 col-md-6 col-lg-4 image-center"]//a');
    for ($i=0; $i<$node_list->count(); ++$i) {
        $link = $node_list->item($i)->getAttribute("href");
        $url_list[] = "https://www.formula1.com" . $link;
    }
    $node_list = $xpath->query('//div[@class="col-12 col-md-6 col-lg-4 col-xl-3"]//a');
    for ($i=0; $i<$node_list->count(); ++$i) {
        $link = $node_list->item($i)->getAttribute("href");
        $url_list[] = "https://www.formula1.com" . $link;
    }

    return [$name_list, $lastname_list, $flag_list, $team_list, $number_list, $img_list, $url_list];
}