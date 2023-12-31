<?php

function get_data_id($product): string {
    return " data-id=\"" . $product["Products.id"] .
        "\" data-title=\"" . $product["Products.title"] .
        "\" data-description=\"" . $product["Products.description"] .
        "\" data-price=\"" . $product["Products.price"] .
        "\" data-img=\"" . $product["Products.img_url"] .
        "\" data-team_id=\"" . $product["Teams.id"] .
        "\" data-team_name=\"" . $product["Teams.name"] . "\"";
}

function str2int_dec($str): array {
    $int = intval($str / 100);
    $dec = $str % 100;
    if ($dec < 10) {
        $dec = "0" . $dec;
    }
    return [$int, $dec];
}