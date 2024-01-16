<?php
const BASE_URL_STATISTICS = "https://www.formula1.com/en/results.html/2023/races.html";

function f1_scrape_stat($base_url): array
{

    // Init arrays of interest
    $info = [];
    $date = [];
    $car = [];
    $laps = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    $node_list = $xpath->query('//td[@class="dark bold"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;

        // frist element gp, second name_driver, third lastname_driver and ver
        $info[] = $node;
    }

    $node_list = $xpath->query('//td[@class="dark hide-for-mobile"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;

        $date[] = $node;
    }

    $node_list = $xpath->query('//td[@class="semi-bold uppercase "]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;

        $car[] = $node;
    }

    $node_list = $xpath->query('//td[@class="bold hide-for-mobile"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;

        $laps[] = $node;
    }


    return [$info, $date, $car, $laps];
}
