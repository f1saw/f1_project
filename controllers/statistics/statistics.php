<?php
const BASE_URL_STATISTICS = "https://www.formula1.com/en/results.html/2024/races.html";

function f1_scrape_stat($base_url): array {

    // Init arrays of interest
    $info = [];
    $date = [];
    $car = [];
    $laps = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get Race Information
    $node_list = $xpath->query('//td[@class="dark bold"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;

        // [GP_Name, Driver_Name]
        // e.g. Bahrain ; Max Verstappen VER
        $info[] = $node;
    }

    // Get Race Date
    $node_list = $xpath->query('//td[@class="dark hide-for-mobile"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;
        $date[] = $node;
    }

    // Get Car Name
    $node_list = $xpath->query('//td[@class="semi-bold uppercase "]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;
        $car[] = $node;
    }

    // Get Laps
    $node_list = $xpath->query('//td[@class="bold hide-for-mobile"]');
    foreach ($node_list as $n) {
        $node = $n->nodeValue;
        $laps[] = $node;
    }

    return [$info, $date, $car, $laps];
}