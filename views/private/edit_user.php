<?php
require_once("../../auth/auth.php");
require_once("../../error_handling.php");
require_once("../../DB/DB.php");

if(session_status() == PHP_SESSION_NONE) session_start();
[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    $post_name = ["edit_firstname", "edit_lastname", "edit_img", "edit_role"];
    $db_col_edit = ["first_name", "last_name", "img_url", "role"];


    if(isset($_POST[$post_name[3]]) && $_POST[$post_name[3]] != ""){
        if(!is_numeric($_POST[$post_name[3]])){
            error("401",
                " Unauthorized access.",
                "edit_user.php",
                "/f1_project/views/private/dashboard.php",
                "Please enter a number.");
        }

        if($_POST[$post_name[3]] != 0){
            $_POST[$post_name[3]] = 1;
        }

        $conn = DB::connect();
        $role = DB::get_record_by_field($conn,
            "SELECT role FROM Users WHERE id = ?",
            ["i"],
            [$_POST["Button"]],
            "/f1_project/views/private/edit_user.php",
            "/f1_project/views/private/edit_user.php")[0];

        if (!$conn->close()) {
            error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/dashboard.php");
            exit;
        }

        if($role["role"] == 1){
            error("401",
                " Unauthorized access.",
                "edit_user.php",
                "/f1_project/views/private/dashboard.php",
                "You can only change the value of a user with role 0 to 1.");
            exit;
        }
    }

    for($i=0; $i <4; ++$i){
        if (isset($_POST[$post_name[$i]]) && isset($_POST['Button']) &&
            $_POST[$post_name[$i]] != ""){
            $change_value = $_POST[$post_name[$i]];
            $conn = DB::connect();
            DB::p_stmt_no_select(
                $conn,
                "UPDATE users SET $db_col_edit[$i] = '$change_value' WHERE id = ?",
                ["i"],
                [$_POST['Button']],
                "/f1_project/views/private/edit_user.php",
                "/f1_project/views/private/edit_user.php"
            );
            if (!$conn->close()) {
                error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/dashboard.php");
                exit;
            }

            $_SESSION["success"] = 1;
            $_SESSION["success_msg"] = "Modification completed successfully.";
            header("location: /f1_project/views/private/dashboard.php");
        }
    }
}
else{
    error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
