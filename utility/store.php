<?php
/** Returns string within Product information through data-info method.
 * @param $product
 * @return string
 */
function get_data_id($product): string {
    return " data-id=\"" . $product["Products.id"] .
        "\" data-title=\"" . $product["Products.title"] .
        "\" data-description=\"" . $product["Products.description"] .
        "\" data-price=\"" . $product["Products.price"] .
        "\" data-img=\"" . $product["Products.img_url"] .
        "\" data-team_id=\"" . $product["Teams.id"] .
        "\" data-team_name=\"" . $product["Teams.name"] . "\"";
}

/** Returns an array [$int, $dec] where the 1st element is the integer part of parameter number,
 *  while the 2nd one is the decimal part.
 * @param $str
 * @return array
 */
function str2int_dec($str): array {
    $int = intval($str / 100);
    $dec = $str % 100;
    if ($dec < 10) {
        $dec = "0" . $dec;
    }
    return [$int, $dec];
}