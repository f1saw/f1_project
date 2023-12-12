<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/profile_style.css">


    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once("../../utility/utility_func.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>

</head>

<body class="bg-dark">
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php
// error_redirector, link ai css non funzionano, why??
[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);

    if(check_admin_auth($user)) {
        (isset($_GET["id"]) && $_GET["id"] != null) ? $id = $_GET["id"] : $id = null;

        $element = choose_correct_data($id);
        unset($id);
    }
    else{
        $element = choose_correct_data(null);
    }

    if($element != null) {
        if (isset($_GET["edit"]) && $_GET["edit"] == 1) {
            include("../partials/user_detail_edit_profile.php");
        } else {
            include("../partials/user_detail_show_profile.php");
        }
    }
    else{
        error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "No user found");
    }
}
else{
    error("401", "not_authorized", "/f1_project/views/private/user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>


