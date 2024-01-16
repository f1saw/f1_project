<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

if(isset($_GET["url"])) {

    $array_value = [];

    $base_url = $_GET["url"];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    $node_list = $xpath->query('//td[@class="stat-value"]');
    foreach ($node_list as $n) {
        $value = $n->nodeValue;
        $array_value[] = $value;
    }

    echo json_encode($array_value);
}
function f1_scrape_info_drivers($base_url): array
{

    // Init arrays of interest
    $array_value = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    $node_list = $xpath->query('//td[@class="stat-value"]');
    foreach ($node_list as $n) {
        $value = $n->nodeValue;
        $array_value[] = $value;
    }

    return $array_value;
}