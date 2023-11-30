<!DOCTYPE html>
<html lang="it">

<head>
    <title>Login</title>
    <meta charset="UTF-8">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
</head>

<body>


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

<div class="container-fluid vh-100 w-100 d-flex flex-column justify-content-center align-items-center">

    <form id="signup-form" action="/f1_project/auth/login.php" class="container col-12 col-md-6" method="POST">

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
            <legend><b>LOGIN</b></legend>
            <hr>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="email" class="form-label"><b>EMAIL</b></label><br>
                    <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="password" class="form-label"><b>PASSWORD</b></label><br>
                    <input type="password" class="form-control" id="password" name="pass" placeholder="Password" required>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-12">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                    <label class="form-check-label mx-1" for="remember_me">
                        Remember me
                    </label>
                </div>
            </div>
            <hr>
            <div class="row d-flex justify-content-end align-items-center mx-1">
                <button type="submit" class="btn btn-primary col-9 col-sm-5 col-md-3"><b>Sign in</b></button>
                <a href="/f1_project/views/public/registration_form.php" class="col-2 text-center text-decoration-none">Back</a>
            </div>
        </fiedlset>
    </form>
</div>
</body>
</html>