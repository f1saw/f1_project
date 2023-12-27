<?php
require_once("utility/error_handling.php");

//TODO: e_code e e_msg da rivedere

function msg_err_user_delete($msg) : void{
    error("401",
        " Unauthorized access.",
        "/f1_project/views/private/user_delete.php",
        "/f1_project/views/private/table_users.php",
        $msg);
}

function msg_err_edit_user($msg) : void{
    error("401",
        " Unauthorized access.",
        "/f1_project/views/private/edit_user.php",
        "/f1_project/views/private/user_detail.php",
        $msg);
}

function msg_err_edit_user_admin($msg) : void{
    error("401",
        " Unauthorized access.",
        "/f1_project/views/private/edit_user.php",
        "/f1_project/views/private/table_users.php",
        $msg);
}

function msg_error($user_id, $active_user_role, $active_user_id, $msg) : void {
    if ($active_user_role == 1 && $user_id != $active_user_id){
        msg_err_edit_user_admin($msg);
        exit;
    }
    msg_err_edit_user($msg);
}
