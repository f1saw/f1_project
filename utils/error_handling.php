<?php

if(session_status() == PHP_SESSION_NONE) session_start();

function error($e_code = "", $e_msg = "", $source = "", $redirect = "", $e_usr_msg = "") : void {
    $path = realpath($_SERVER["DOCUMENT_ROOT"]) . "\\$source";
    $e_json = "{\n" .
        "\t\"path\": \"$path\",\n" .
        "\t\"error_code\": \"$e_code\",\n " .
        "\t\"error_message\": \"$e_msg\"\n" .
        "},\n";
    error_log($e_json, 3, "../errors.log");

    $_SESSION["err"] = 1;
    $_SESSION["err_msg"] = ($e_usr_msg != "")? $e_usr_msg:$e_msg;
    // header("Location: http://".$_SERVER['HTTP_HOST'].$formaction;
    header("Location: $redirect");
}