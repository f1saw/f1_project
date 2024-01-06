<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("views/partials/alert.php");

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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sign Up</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/log_reg_style.css">

    <?php if (isset($_SESSION["confirm_email"]) && !$_SESSION["confirm_email"]){ ?>
        <link rel="stylesheet" href="/f1_project/assets/css/text_confirm_email.css">
    <?php } ?>

    <?php include("views/partials/head.php"); ?>
</head>

<?php if(isset($_SESSION["err"]) && $_SESSION["err"]){ ?>
<style>
    .container-element{
        top: 40px;
        height: 650px;
    }
</style>
<?php } ?>

<body class="bg-dark">

<div id="bg-register" class="container-fluid">

    <?php include("views/partials/navbar_log_reg.php"); ?>

    <div class="flex-container d-flex justify-content-center">
        <?php
        if (isset($_SESSION["confirm_email"]) && !$_SESSION["confirm_email"]){?>
            <div class="container-element text">
                <h1>Request received</h1>
                <br>
                <h3>Check your mailbox and confirm your email.</h3>
                <h3>Once confirmed, refresh this page and log in</h3>
            </div>
        <?php }
        else if (isset($_SESSION["confirm_email"]) && $_SESSION["confirm_email"]){
            unset($_SESSION["confirm_email"]);
            header("location: /f1_project/views/public/auth/login.php");
            exit;
        }
        else{ ?>
        <form id="register-form" action="/f1_project/controllers/auth/registration_email.php" method="POST" class="container-element reg">

            <div style="margin-left: 10px; margin-right: 10px">
            <?php $function = "document.getElementsByClassName('reg')[0].style.height = '550px'; 
                               document.getElementsByClassName('container-element')[0].style.top = '100px';" ?>
            <?php err_msg_alert($function); ?>
            </div>

            <fieldset>
                <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                    <span class="material-symbols-outlined">passkey</span>
                    <b>REGISTER</b>
                </legend>
                <hr>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                        <label for="fname" class="form-label text-box"><strong>FIRST NAME</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="fname-addon">badge</span>
                            <input type="text" id="fname" name="fname" class="form-control" placeholder="Your first name" aria-describedby="fname-addon" required>
                        </div>
                        <!-- <div class="form-text"></div> -->
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="lname" class="form-label text-box"><strong>LAST NAME</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="fname-addon">badge</span>
                            <input type="text" id="lname" name="lname" class="form-control" placeholder="Your last name" required>
                        </div>
                        <!-- <div class="form-text"></div> -->
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="email" class="form-label text-box"><strong>EMAIL</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="email-addon">mail</span>
                            <input type="email" id="email" class="form-control" name="email" pattern='^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$' placeholder="name@example.com" aria-describedby="email-addon" required>
                        </div>
                        <div class="form-text mx-1 text-light"><p class="text-box"> your <strong>Top secret</strong> email :P </p></div>
                        <div id="input-info-email" class="d-none d-flex gap-2 mt-1 py-1 text-box">
                            <span class="material-symbols-outlined"></span>
                            <span class=""></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                        <label for="password" class="form-label text-box"><strong>PASSWORD</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="password-addon">lock</span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div id="input-info-pass" class="d-none d-flex gap-2 mt-1 py-1 text-box">
                            <span class="material-symbols-outlined"></span>
                            <span class=""></span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="password_confirm" class="form-label text-box"><strong>REPEAT PASSWORD</strong></label><br>
                        <div class="input-group">
                            <span class="input-group-text material-symbols-outlined text-dark text-box" id="password-addon">lock</span>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Repeat password">
                        </div>
                        <div id="input-info-pass-confirm" class="d-none d-flex gap-2 mt-1 py-1 text-box">
                            <span class="material-symbols-outlined"></span>
                            <span class=""></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                        <label for="date_of_birth" class="form-label text-box"><strong>Date of birth</strong></label>
                        <div class="input-group">
                            <input id="date_of_birth" name="date_of_birth" class="form-control text-box" type="date" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0 d-flex align-items-end">
                        <div class="d-flex flex-row gap-1">
                            <input class="form-check-input text-box" type="checkbox" id="newsletter" name="newsletter">
                            <label class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="newsletter" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="Receive <strong>exclusive</strong> contents :P">
                                Subscribe to newsletter
                                <span class="material-symbols-outlined" style="color: aqua; margin-right: 12px">help</span>
                            </label>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row col-12 d-flex justify-content-center align-items-center mx-1 gap-3">
                    <button type="submit" class="btn btn-danger col-8 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined">person_add</span>
                        <strong>Sign up</strong>
                    </button>
                    <a href="login.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
                        <span class="material-symbols-outlined">login</span>
                        <span class="d-inline d-xxl-inline">Login</span>
                    </a>
                </div>
            </fieldset>
        </form>
        <?php
        }
        ?>
    </div>
</div>
</body>

<script src="/f1_project/assets/js/validators/user.js"></script>
<script src="/f1_project/assets/js/tooltip.js"></script>
</html>