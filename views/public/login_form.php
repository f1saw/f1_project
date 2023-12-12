<!DOCTYPE html>
<html lang="it">

<head>
    <title>Login</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../assets/css/log_reg_style.css">
    <link rel="stylesheet" href="../../assets/css/style.css">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
    <?php include("../partials/alert.php"); ?>
</head>

<?php
if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);
    if (check_admin_auth($user)) {
        header("Location: /f1_project/views/private/table_users.php");
    } else {
        echo "Logged but in user mode";
        echo "<a href='/f1_project/views/private/logout.php'>Logout</a>";
    }
    exit;
}
?>

<body class="vh-100">

<?php include ("../partials/navbar_log_reg.php"); ?>

<div id="bg-login" class="container-fluid h-100 w-100 d-flex flex-column justify-content-center align-items-center">

    <form id="login-form" action="../../auth/login.php" class="container col-12 col-lg-6 col-xl-4 py-3 border border-3 border-danger rounded" method="POST">

        <?php err_msg_alert(); ?>
        <?php succ_msg_alert(); ?>

        <fiedlset>
            <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                <span class="material-symbols-outlined">passkey</span>
                <strong>LOGIN</strong>
            </legend>
            <hr>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="email" class="form-label"><strong>EMAIL</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="email-addon">mail</span>
                        <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" aria-describedby="email-addon" required>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="password" class="form-label"><strong>PASSWORD</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="password-addon">lock</span>
                        <input type="password" class="form-control" id="password" name="pass" placeholder="Password" aria-describedby="password-addon" required>
                    </div>

                </div>
            </div>
            <div class="row mb-3 mt-5">
                <div class="col-12 d-flex flex-row gap-1">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                    <label class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="remember_me" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<div class='d-flex justify-content-center align-items-center gap-2'>Provided by <span class='material-symbols-outlined'>cookie</span></div>">
                        Remember me
                        <span class="material-symbols-outlined" style="color: aqua;">help</span>
                    </label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 d-flex flex-row gap-1 hover-red">
                    <a href="lost_password_form.php" class="text-white text-decoration-none my_outline_animation mx-1 d-flex align-items-center justify-content-start gap-2 py-2">
                        <span class="material-symbols-outlined">key_off</span>
                        <span>Password dimenticata<strong> ?</strong></span>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row col-12 d-flex justify-content-end align-items-center mx-1 gap-3">
                <button type="submit" class="btn btn-danger col-12 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                    <span class="material-symbols-outlined text-light">login</span>
                    <strong>Sign in</strong>
                </button>
                <a href="/f1_project/views/public/registration_form.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
                    <span class="material-symbols-outlined">how_to_reg</span>
                    <span class="d-inline d-sm-none d-xxl-inline">Register</span>
                </a>
            </div>
        </fiedlset>
    </form>
</div>
</body>


<script src="../../assets/js/tooltip.js"></script>
</html>