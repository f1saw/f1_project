<?php
const BASE_URL_TEAMS = "https://www.formula1.com/en/teams.html";

function f1_scrape_teams($base_url): array {

    // Init arrays of interest
    $team_list = [];
    $name_list = [];
    $car_img_list = [];
    $logo_img_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get TEAMS
    $node_list = $xpath->query('//span[contains(@class, "tracking-normal")]');
    foreach ($node_list as $n) {
        $team = $n->nodeValue;
        $team_list[] = $team;
    }

    // Get Cars IMGs
    $node_list = $xpath->query('//img[@class="f1-c-image"]');
    foreach ($node_list as $node) {
        $car_img_list[] = $node->getAttribute("src");
    }

    // Get Logos IMGs
    $node_list = $xpath->query('//img[@class="f1-c-image h-[2em] ml-auto mr-0"]');
    foreach ($node_list as $node) {
        $logo_img_list[] = $node->getAttribute("src");
    }

    // Get drivers names
    $node_list = $xpath->query('//div[contains(@class, "f1-team-driver-name")]');
    foreach ($node_list as $n) {
        $name = "";
        foreach ($n->childNodes as $n_inner) {
            $name .= $n_inner->nodeValue . " ";
        }
        $name_list[] = $name;
    }

    return [$name_list, $team_list, $car_img_list, $logo_img_list];
}