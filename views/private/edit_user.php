<?php
require_once("../../auth/auth.php");
require_once("../../utility/error_handling.php");
require_once("../../DB/DB.php");
require_once("../../utility/utility_func.php");
require_once("../../utility/msg_error.php");

if(session_status() == PHP_SESSION_NONE) session_start();
[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);

    $post_name = ["edit_firstname", "edit_lastname", "edit_img", "edit_role"];
    $db_col_edit = ["first_name", "last_name", "img_url", "role"];


    if(isset($_POST[$post_name[3]]) && $_POST[$post_name[3]] != ""){
        if(!is_numeric($_POST[$post_name[3]])){
            msg_err_edit_user("Please enter a number.");
            exit;
        }

        if($_POST[$post_name[3]] != 0){
            $_POST[$post_name[3]] = 1;
        }

        $conn = DB::connect();
        $check_role = check_user_role($conn,
        [$_POST["Button_id"]],
        "/f1_project/views/private/edit_user.php",
        "/f1_project/views/private/edit_user.php");

        if ($check_role){
            msg_err_edit_user("You cannot change the administrator role.");
            exit;
        }
    }

    for($i=0; $i <4; ++$i){
        if (isset($_POST[$post_name[$i]]) && isset($_POST['Button_id'])){
            if($_POST[$post_name[$i]] == "") {
                continue;
            }
            $change_value = $_POST[$post_name[$i]];
            $conn = DB::connect();
            DB::p_stmt_no_select(
                $conn,
                "UPDATE users SET $db_col_edit[$i] = '$change_value' WHERE id = ?",
                ["i"],
                [$_POST['Button_id']],
                "/f1_project/views/private/edit_user.php",
                "/f1_project/views/private/edit_user.php"
            );
            if (!$conn->close()) {
                error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/table_users.php");
                exit;
            }
        }
    }
    if(isset($_SESSION['redirection'])){
        header("Location: {$_SESSION['redirection']}");
        unset($_SESSION['redirection']);
        exit;
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Modification completed successfully.";
    header("location: /f1_project/views/private/table_users.php");
}
else{
    error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
