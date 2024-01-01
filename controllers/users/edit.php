<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");

[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);

    $post_name = ["edit_firstname", "edit_lastname", "edit_email", "edit_date_of_birth", "edit_pass",
        "edit_news", "edit_img", "edit_role"];

    $e_firstname = 0;
    $e_lastname = 1;
    $e_email = 2;
    $e_date_of_birth = 3;
    $e_password = 4;
    $e_news = 5;
    $e_img = 6;
    $e_role = 7;

    $db_col_edit = ["first_name", "last_name", "email", "date_of_birth", "password",
        "newsletter", "img_url", "role"];

    for ($j=0; $j<4; ++$j ){
        if (isset($_POST[$post_name[$j]]))
            $_POST[$post_name[$j]] = preg_replace('!\s+!', '', $_POST[$post_name[$j]]);
    }

    if(isset($_POST[$post_name[$e_password]]) && !isset($_POST["edit_pass_confirm"])){
        msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Please confirm the password");
        exit;
    }

    if(isset($_POST[$post_name[$e_password]]))
        $_POST[$post_name[$e_password]] = trim($_POST[$post_name[$e_password]]);

    if(isset($_POST["edit_pass_confirm"]) && $_POST["edit_pass_confirm"] != "") {
        $_POST["edit_pass_confirm"] = trim($_POST["edit_pass_confirm"]);
        if ($_POST["edit_pass_confirm"] == " ") {
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Empty input fields.");
            exit;
        }
    }

    for ($k=0; $k<5; ++$k ){
        if (isset($_POST[$post_name[$k]]) && $_POST[$post_name[$k]] != "") {
            if ($_POST[$post_name[$k]] == " ") {
                msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Empty input fields.");
                exit;
            }
        }
    }

    if(isset($_POST[$post_name[$e_email]]) && $_POST[$post_name[$e_email]] != "") {
        if (!filter_var($_POST[$post_name[$e_email]], FILTER_VALIDATE_EMAIL)) {
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"EMAIL pattern NOT valid.");
            exit;
        }
    }

    if(isset($_POST[$post_name[$e_date_of_birth]]) && $_POST[$post_name[$e_date_of_birth]] != "") {
        if ($_POST[$post_name[$e_date_of_birth]] && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST[$post_name[$e_date_of_birth]])) {
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Date of birth pattern NOT valid.");
            exit;
        }
    }

    if(isset($_POST[$post_name[$e_password]]) && $_POST[$post_name[$e_password]] != "") {
        if ($_POST[$post_name[$e_password]] != $_POST["edit_pass_confirm"]) {
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Mismatched passwords.");
            exit;
        }
        $_POST[$post_name[$e_password]] = password_hash($_POST[$post_name[$e_password]], PASSWORD_DEFAULT);
    }

    if (isset($_POST[$post_name[$e_news]]) && $_POST[$post_name[$e_news]] != ""){
        if(!is_numeric($_POST[$post_name[$e_news]])){
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Newsletter: please enter a number.");
            exit;
        }

        if($_POST[$post_name[$e_news]] != 0){
            $_POST[$post_name[$e_news]] = 1;
        }
    }

    if(isset($_POST[$post_name[$e_role]]) && $_POST[$post_name[$e_role]] != ""){
        if(!is_numeric($_POST[$post_name[$e_role]])){
            msg_error($_POST["Button_id"], $_SESSION["role"], $_SESSION["id"],"Role: please enter a number.");
            exit;
        }

        if($_POST[$post_name[$e_role]] != 0){
            $_POST[$post_name[$e_role]] = 1;
        }

        $conn = DB::connect("\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
        $check_role = check_user_role($conn,
            [$_POST["Button_id"]],
            "\controllers\users\\edit.php",
            "/f1_project/views/private/dashboard.php");

        if ($check_role){
            msg_err_edit_user_admin("You cannot change the administrator role.");
            exit;
        }
    }

    if(isset($_POST[$post_name[$e_email]])){
        $conn = DB::connect("\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
        $check = DB::get_record_by_field(
            $conn,
            "SELECT email FROM users WHERE email = ?",
            ["s"],
            [$_POST[$post_name[$e_email]]],
            "\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
        if($check != null){
            msg_err_edit_user("Email already in use");
        }
        if (!$conn->close()) {
            error("500", "conn_close()", "\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
            exit;
        }
    }

    for($i=0; $i < 8; ++$i) {
        if (isset($_POST[$post_name[$i]]) && isset($_POST['Button_id'])) {
            if($_POST[$post_name[$i]] == "") {
                continue;
            }
            $change_value = $_POST[$post_name[$i]];
            $conn = DB::connect("\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
            DB::p_stmt_no_select(
                $conn,
                "UPDATE users SET $db_col_edit[$i] = '$change_value' WHERE id = ?",
                ["i"],
                [$_POST['Button_id']],
                "\controllers\users\\edit.php", "/f1_project/views/private/users/all.php"
            );
            if (!$conn->close()) {
                error("500", "conn_close()", "\controllers\users\\edit.php", "/f1_project/views/private/users/all.php");
                exit;
            }
        }
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Modification completed successfully.";
    if(isset($_SESSION['redirection'])){
        header("Location: {$_SESSION['redirection']}");
        unset($_SESSION['redirection']);
        exit;
    }
    header("location: /f1_project/views/private/users/all.php");
}
else{
    $_SESSION['redirection'] = "/f1_project/controllers/users/edit.php?id=${${$_POST['Button_id']??''}}";
    error("401", "not_authorized", "\controllers\users\\edit.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
    exit;
}