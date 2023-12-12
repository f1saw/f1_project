<?php

function get_data_id($product): string {
    return " data-id=\"" . $product["id"] .
        "\" data-title=\"" . $product["title"] .
        "\" data-price=\"" . $product["price"] .
        "\" data-img=\"" . $product["img_url"] . "\"";
}

function str2int_dec($str): array {
    $int = intval($str / 100);
    $dec = $str % 100;
    if ($dec < 10) {
        $dec = "0" . $dec;
    }
    return [$int, $dec];
}