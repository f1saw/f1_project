<!DOCTYPE html>
<html lang="it">

<head>
    <title>Sign Up</title>
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
    header('Location: ../private/private.php');
}
?>
<div class="container-fluid vh-100 d-flex flex-column justify-content-center align-items-center">

    <form id="signup-form" action="../../auth/registration.php" method="POST" class="container col-12 col-md-6">
        <?php
        if (isset($_SESSION["err"]) && $_SESSION["err"]) { ?>
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </symbol>
            </svg>
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                <div class="d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <h4 class="alert-heading m-0">Registration failed!</h4>
                </div>
                <hr>
                <p class="mb-0"><?php echo $_SESSION["err_msg"]; ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
            unset($_SESSION["err"]);
            unset($_SESSION["err_msg"]);
        }
        ?>
        <fiedlset>
            <legend><b>CREATE ACCOUNT</b></legend>
            <hr>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="fname" class="form-label"><strong>FIRST NAME</strong></label><br>
                    <input type="text" id="fname" name="fname" class="form-control" placeholder="Your first name" required>
                    <div class="form-text"></div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="lname" class="form-label"><strong>LAST NAME</strong></label><br>
                    <input type="text" id="lname" name="lname" class="form-control" placeholder="Your last name" required>
                    <div class="form-text"></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="email" class="form-label"><b>EMAIL</b></label><br>
                    <input type="email" id="email" class="form-control" name="email" placeholder="name@example.com" required>
                    <div class="form-text mx-1">your <strong>Top secret</strong> email :P</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="password" class="form-label"><strong>PASSWORD</strong></label><br>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="password_confirm" class="form-label"><strong>REPEAT PASSWORD</strong></label><br>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Repeat password">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                    <label for="date_of_birth" class="form-label"><strong>Date of birth</strong></label>
                    <input id="date_of_birth" name="date_of_birth" class="form-control" type="date" />
                </div>
                <div class="col-12 col-sm-6 mb-3 mb-sm-0 d-flex align-items-end">
                    <div>
                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                        <label class="form-check-label mx-1" for="newsletter">
                            Subscribe to newsletter
                        </label>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row d-flex justify-content-end align-items-center mx-1 mb-3">
                <button type="submit" class="btn btn-primary col-9 col-sm-5 col-md-3"><b>Sign up</b></button>
                <a href="login_form.php" class="col-3 text-center text-decoration-none">Login</a>
            </div>
        </fiedlset>

    </form>
</div>
</body>
</html>