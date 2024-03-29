<?php
const BASE_URL_TEAMS = "https://www.formula1.com/en/teams.html";

function f1_scrape_teams($base_url): array {

    // Init arrays of interest
    $team_list = [];
    $name_list = [];
    $lastname_list = [];
    $img_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get TEAMS
    $node_list = $xpath->query('//span[@class="f1-color--black"]');
    foreach ($node_list as $n) {
        $team = $n->nodeValue;
        $team_list[] = $team;
    }

    // Get images
    $node_list = $xpath->query('//picture[@class="team-car"]//img');
    for ($i=0; $i<20; ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");

        // 1st element: logo image
        // 2nd element: car image
        $img_list[] = $link;
    }

    // Get drivers names
    $node_list = $xpath->query('//span[@class="first-name f1--xs d-block d-lg-inline"]');
    foreach ($node_list as $n) {
        $name = $n->nodeValue;
        $name_list[] = $name;
    }

    // Get drivers last names
    $node_list = $xpath->query('//span[@class="last-name f1-uppercase f1-bold--xs d-block d-lg-inline"]');
    foreach ($node_list as $n) {
        $lastname = $n->nodeValue;
        $lastname_list[] = $lastname;
    }

    return [$name_list, $lastname_list, $team_list, $img_list];
}