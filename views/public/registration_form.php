<!DOCTYPE html>
<html lang="it">

<head>
    <title>Sign Up</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/log_reg_style.css">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
    <?php require_once ("../partials/alert.php"); ?>
</head>

<?php
if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);
    if (check_admin_auth($user)) {
        header("Location: /f1_project/views/private/dashboard.php");
    } else {
        echo "Logged but in user mode";
        echo "<a href='/f1_project/views/private/logout.php'>Logout</a>";
    }
    exit;
}
?>


<body class="vh-100">

<?php include ("../partials/navbar_log_reg.php"); ?>

<div id="bg-register" class="container-fluid h-100 w-100 d-flex flex-column justify-content-center align-items-center">

    <form id="register-form" action="../../auth/registration.php" method="POST" class="container col-12 col-xl-6 py-3 border border-3 border-danger rounded">

        <?php err_msg_alert(); ?>

        <fiedlset>
            <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                <span class="material-symbols-outlined">passkey</span>
                <b>REGISTER</b>
            </legend>
            <hr>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="fname" class="form-label"><strong>FIRST NAME</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="fname-addon">badge</span>
                        <input type="text" id="fname" name="fname" class="form-control" placeholder="Your first name" aria-describedby="fname-addon" required>
                    </div>
                    <!-- <div class="form-text"></div> -->
                </div>
                <div class="col-12 col-md-6">
                    <label for="lname" class="form-label"><strong>LAST NAME</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="fname-addon">badge</span>
                        <input type="text" id="lname" name="lname" class="form-control" placeholder="Your last name" required>
                    </div>
                    <!-- <div class="form-text"></div> -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="email" class="form-label"><strong>EMAIL</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="email-addon">mail</span>
                        <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" aria-describedby="email-addon" required>
                    </div>
                    <div class="form-text mx-1 text-light">your <strong>Top secret</strong> email :P</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="password" class="form-label"><strong>PASSWORD</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="password-addon">lock</span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="password_confirm" class="form-label"><strong>REPEAT PASSWORD</strong></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="password-addon">lock</span>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Repeat password">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                    <label for="date_of_birth" class="form-label"><strong>Date of birth</strong></label>
                    <input id="date_of_birth" name="date_of_birth" class="form-control" type="date" />
                </div>
                <div class="col-12 col-sm-6 mb-3 mb-sm-0 d-flex align-items-end">
                    <div class="d-flex flex-row gap-1">
                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                        <label class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="newsletter" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="Receive <strong>exclusive</strong> contents :P">
                            Subscribe to newsletter
                            <span class="material-symbols-outlined" style="color: aqua;">help</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row col-12 d-flex justify-content-end align-items-center mx-1 mb-3 gap-3">
                <button type="submit" class="btn btn-danger col-12 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                    <span class="material-symbols-outlined">person_add</span>
                    <strong>Sign up</strong>
                </button>
                <a href="login_form.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
                    <span class="material-symbols-outlined">login</span>
                    <span class="d-inline d-xxl-inline">Login</span>
                </a>
            </div>
        </fiedlset>

    </form>
</div>
</body>

<script src="../../assets/js/tooltip.js"></script>
</html>