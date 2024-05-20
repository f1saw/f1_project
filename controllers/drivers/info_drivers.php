<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

if(isset($_GET["url"])) {
    $base_url = $_GET["url"];
    $array_value = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    // Get DRIVER STATISTICS
    $node_list = $xpath->query('//dd[contains(@class, "f1-text")]');
    foreach ($node_list as $n) {
        $value = $n->nodeValue;
        $array_value[] = $value;
    }

    echo json_encode($array_value);
}