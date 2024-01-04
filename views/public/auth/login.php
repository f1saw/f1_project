<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("views/partials/alert.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/log_reg_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
</head>

<?php
if(isset($_SESSION["err"]) && $_SESSION["err"] || isset($_SESSION["success"]) && $_SESSION["success"]){ ?>
    <style>
        .container-element{
            height: 550px;
        }
    </style>
<?php } ?>

<?php
[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);
    if (check_admin_auth($user)) {
        header("Location: /f1_project/views/private/users/all.php");
    } else {
        echo "Logged but in user mode";
        echo "<a href='/f1_project/controllers/auth/logout.php'>Logout</a>";
    }
    exit;
}
?>

<body class="bg-dark vh-100">

<div id="bg-login" class="container-fluid">
<?php include("views/partials/navbar_log_reg.php"); ?>

        <div class="flex-container d-flex justify-content-center">
            <form id="login-form" action="/f1_project/controllers/auth/login.php" class="container-element log" method="POST">

                <div style="margin-left: 10px; margin-right: 10px">
                <?php $function = "document.getElementsByClassName('container-element')[0].style.height = '480px'" ?>
                <?php err_msg_alert($function); ?>
                <?php succ_msg_alert($function); ?>
                </div>

                <fieldset>
                    <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                        <span class="material-symbols-outlined">passkey</span>
                        <strong>LOGIN</strong>
                    </legend>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 text-box">
                            <label for="email" class="form-label"><strong>EMAIL</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="email-addon">mail</span>
                                <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" aria-describedby="email-addon" required>
                            </div>
                            <div id="select-info-email" class="d-none d-flex gap-2 mt-1 py-1">
                                <span class="material-symbols-outlined"></span>
                                <span class=""></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-box">
                            <label for="password" class="form-label"><strong>PASSWORD</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="password-addon">lock</span>
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Password" aria-describedby="password-addon" required>
                            </div>
                            <div id="select-info-pass" class="d-none d-flex gap-2 mt-1 py-1">
                                <span class="material-symbols-outlined"></span>
                                <span class=""></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 mt-4">
                        <div class="col-12 d-flex flex-row gap-1 text-box">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                            <label class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="remember_me" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<div class='d-flex justify-content-center align-items-center gap-2'>Provided by <span class='material-symbols-outlined'>cookie</span></div>">
                                Remember me
                                <span class="material-symbols-outlined" style="color: aqua;">help</span>
                            </label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 d-flex flex-row gap-1 hover-red text-box">
                            <a href="/f1_project/views/public/auth/lost_password.php" class="text-white text-decoration-none my_outline_animation mx-1 d-flex align-items-center justify-content-start gap-2 py-2">
                                <span style="margin-left: -5px" class="material-symbols-outlined">key_off</span>
                                <span>Password dimenticata<strong> ?</strong></span>
                            </a>
                        </div>
                    </div>
                    <div class="text-box col-12">
                        <label>
                            <label class="text-danger">*</label> Compulsory fields
                        </label>
                    </div>
                    <hr>
                    <div class="row col-12 d-flex justify-content-center align-items-center mx-1 gap-3 mb-3">
                        <button type="submit" class="btn btn-danger col-8 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                            <span class="material-symbols-outlined text-light">login</span>
                            <strong>Sign in</strong>
                        </button>
                        <a href="/f1_project/views/public/auth/registration.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
                            <span class="material-symbols-outlined">how_to_reg</span>
                            <span class="d-inline d-xxl-inline">Register</span>
                        </a>
                    </div>
                </fieldset>
            </form>
        </div>
</div>
</body>

<script src="/f1_project/assets/js/validators/user.js"></script>
<script src="/f1_project/assets/js/tooltip.js"></script>
</html>