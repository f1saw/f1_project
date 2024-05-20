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
    $flag_list = [];
    $url_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get TEAMS
    $node_list = $xpath->query('//p[@class="f1-heading tracking-normal text-fs-12px leading-tight normal-case font-normal non-italic f1-heading__body font-formulaOne text-greyDark"]');
    foreach ($node_list as $n) {
        $team = $n->nodeValue;
        $team_list[] = $team;
    }

    // Get NAMES
    $node_list = $xpath->query('//div[contains(@class, "f1-driver-name")]');
    foreach ($node_list as $n) {
        $name = "";
        foreach ($n->childNodes as $n_inner) {
            $name .=  $n_inner->nodeValue . " ";
        }

        $name_list[] = $name;
    }

    // Get FLAGS, NUMBERS, IMGs
    $saving_idx = 0;
    $node_list = $xpath->query('//div[contains(@class, "f1-inner-wrapper")]//img');
    for ($i=0; $i<$node_list->count(); ++$i) {
        if ($node_list->item($i)) {
            $link = $node_list->item($i)->getAttribute("src");
            switch ($saving_idx) {
                case 0: $flag_list[] = $link; break;
                case 1: $number_list[] = $link; break;
                case 2: $img_list[] = $link; break;
            }
            $saving_idx++;
            $saving_idx = $saving_idx % 3;
        }
    }

    // Get EXTRA INFO
    $node_list = $xpath->query('//a[contains(@class, "focus-visible:outline-2")]');
    for ($i=0; $i<$node_list->count(); ++$i) {
        if ($node_list->item($i)) {
            $link = $node_list->item($i)->getAttribute("href");
            $url_list[] = "https://www.formula1.com" . $link;
        }
    }

    return [$name_list, $team_list, $flag_list, $number_list, $img_list, $url_list];
}