<?php

function str2int_dec($str) {
    $int = intval($str / 100);
    $dec = $str % 100;
    if ($dec < 10) {
        $dec = "0" . $dec;
    }
    return [$int, $dec];
}