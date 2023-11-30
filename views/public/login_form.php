<!DOCTYPE html>
<html lang="it">

<head>
    <title>Login</title>
    <meta charset="UTF-8">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>

    <style>
        * {
            color: white;
        }

        .material-symbols-outlined:hover {
            color: red;
        }

        #navbar {
            position: absolute;
            background-color: transparent;
        }

        #navbar-logo {
            width: 70px;
            height: 70px;
            background-image: url('/f1_project/images/F1.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        #bg-login {
            background: url("/f1_project/images/FEpfHeBXwAMnIJA.jpeg");
            background-size: cover;
            background-position: bottom;
        }

        #bg-login #login-form {
            background: rgba(87, 87, 87, .6);
            backdrop-filter: blur(5px);
        }

        hr {
            border-top: 3px solid red;
        }

        .my_outline_animation {
            border: none;
            position: relative;
            transition: all ease-in-out .2s;
        }

        .my_outline_animation::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            left: 50%;
            bottom: 0;
            background-color: red;
            transition: all ease-in-out .2s;
        }

        .my_outline_animation:hover::after {
            width: 100%;
            left: 0;
        }
    </style>
</head>

<?php
if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);
    header("Location: ../private/private.php");
}
?>

<body class="vh-100">

<nav id="navbar" class="w-100 navbar">
    <div class="container-fluid px-4">
        <a id="navbar-logo" class="navbar-brand px-5" href="/f1_project/views/public/index.php"></a>
        <div class="d-md-flex justify-content-end align-items-center">
            <ul class="navbar-nav mb-2 mb-lg-0 p-2 d-flex flex-row gap-5">
                <li class="nav-item">
                    <a href="/f1_project/views/public/who.php" class="my_outline_animation p-2 text-decoration-none text-white d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined text-danger">groups</span>
                        Chi siamo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/f1_project/views/public/where.php" class="my_outline_animation p-2 text-decoration-none text-white d-flex align-items-center justify-content-center gap-2">
                        <span class="material-symbols-outlined text-danger">map</span>
                        Dove
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div id="bg-login" class="container-fluid h-100 w-100 d-flex flex-column justify-content-center align-items-center">

    <form id="login-form" action="../../auth/login.php" class="container col-12 col-md-6 col-lg-4 col-xl-3 py-3 border border-3 border-danger rounded" method="POST">

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>

        <?php


        if (isset($_SESSION["success"]) && $_SESSION["success"]) { ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mt-4 col-12" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <b>Success!</b>&nbsp;<?php echo $_SESSION["success_msg"]; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION["success"]);
            unset($_SESSION["success_msg"]);
        }
        ?>


        <?php
        if (isset($_SESSION["err"]) && $_SESSION["err"]) { ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mt-4 col-12" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <b>ERROR!</b>&nbsp;<?php echo $_SESSION["err_msg"]; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION["err"]);
            unset($_SESSION["err_msg"]);
        } ?>

        <fiedlset>
            <legend class="d-flex align-items-center justify-content-start gap-2">
                <span class="material-symbols-outlined">passkey</span>
                <b>LOGIN</b>
            </legend>
            <hr>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="email" class="form-label"><b>EMAIL</b></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="email-addon">mail</span>
                        <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" aria-describedby="email-addon" required>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="password" class="form-label"><b>PASSWORD</b></label><br>
                    <div class="input-group">
                        <span class="input-group-text material-symbols-outlined text-dark" id="password-addon">lock</span>
                        <input type="password" class="form-control" id="password" name="pass" placeholder="Password" aria-describedby="password-addon" required>
                    </div>

                </div>
            </div>
            <div class="row mb-3 mt-5">
                <div class="col-12 d-flex flex-row gap-1">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                    <label class="form-check-label mx-1 d-flex align-items-center justify-content-start gap-2" for="remember_me" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<em>Tooltip</em> <u>with</u> <b>HTML</b>" >
                        Remember me
                        <span class="material-symbols-outlined" style="color: aqua;">help</span>
                    </label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 d-flex flex-row gap-1">
                    <a href="lost_password_form.php" class="text-white text-decoration-none">
                    <label class="my_outline_animation mx-1 d-flex align-items-center justify-content-start gap-2 py-2" >
                        <span class="material-symbols-outlined">key_off</span>
                        Password dimenticata
                    </label>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row d-flex justify-content-end align-items-center mx-1 gap-3">
                <button type="submit" class="btn btn-danger col-9 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                    <span class="material-symbols-outlined text-light">login</span>
                    <b>Sign in</b>
                </button>
                <a href="/f1_project/views/public/registration_form.php" class=" col-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2">
                    <span class="material-symbols-outlined">how_to_reg</span>
                    <span class="d-none d-xxl-inline">Register</span>
                </a>
            </div>
        </fiedlset>
    </form>
</div>
</body>

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
</html>