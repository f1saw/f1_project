<?php
require_once("error_handling.php");

//TODO: e_code e e_msg da rivedere

function msg_err_user_delete($msg) : void{
    error("401",
        " Unauthorized access.",
        "/f1_project/views/private/user_delete.php",
        "/f1_project/views/private/dashboard.php",
        $msg);
}

function msg_err_edit_user($msg) : void{
    error("401",
        " Unauthorized access.",
        "/f1_project/views/private/edit_user.php",
        "/f1_project/views/private/dashboard.php",
        $msg);
}