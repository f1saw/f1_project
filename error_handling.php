<?php

if(session_status() == PHP_SESSION_NONE) session_start();

$_DEFAULT_ERROR_REDIRECT = "index.php";

function error($e_code = "", $e_msg = "", $source = "", $redirect = "", $e_usr_msg = "") : void {
    global $_DEFAULT_ERROR_REDIRECT;

    $path = realpath($_SERVER["DOCUMENT_ROOT"]) . "\\$source";
    $e_json = "{\n" .
        "\t\"path\": \"$path\",\n" .
        "\t\"error_code\": \"$e_code\",\n " .
        "\t\"error_message\": \"$e_msg\"\n" .
        "},\n";
    $path = $_SERVER["DOCUMENT_ROOT"] . "/errors.log";
    error_log($e_json, 3, $path);

    $_SESSION["err"] = 1;
    $_SESSION["err_msg"] = ($e_usr_msg != "")? $e_usr_msg:$e_msg;
    // header("Location: http://".$_SERVER['HTTP_HOST'].$formaction;
    $redirect = ($redirect != "")? $redirect : $_DEFAULT_ERROR_REDIRECT;
    header("Location: $redirect");
    exit;
}