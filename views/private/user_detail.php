<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>

    <!--
    I link non funzionano se passo dalla table users
    Se invece dalla dashboard clicco su Profile tutto ok
    Che succede bugo?

    <link rel="stylesheet" href="../../assets/css/profile_style.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    -->

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once("../../utility/utility_func.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>

    <meta charset="UTF-8">

    <!-- In attesa di risolvere il bug -->
    <style>
        main {
            max-width: 1335px;
            margin: auto;
        }

        .container {
            position: relative;
            height: 85vh;
            width: 100%;
            overflow: hidden;
            border-radius: 10px;
            display: flex;
            display: -webkit-flex;

        }

        .container-element{
            position: relative;
            backdrop-filter: blur(5px);
            max-height: 70%;
            width: 40%;
            height: 100%;
            border-radius: 10px;
            top: 100px;
            border-style: solid;
            border-color: #ff1300;
        }

        @media screen and (max-width: 992px) {
            .container-element{
                max-width: 70%;
                max-height: 68%;
                width: 100%;
                height: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .container-element{
                max-width: 70%;
                max-height: 84%;
                width: 100%;
                height: 100%;
            }
        }

        #bg-profile {
            background: url("/f1_project/assets/images/circuit.jpeg");
            background-size: cover;
            background-position: bottom;
            border-radius: 10px;
        }

        #bg-profile #profile-data {
            background: rgba(87, 87, 87, .6);
        }

        #photo_profile{
            position: relative;
            width: 70px;
            height: 70px;
            top: 20px
        }

        .text-box{
            margin-left: 10px;
            margin-right: 10px;
        }

        input{
            text-align: center;
        }
        input::placeholder {
            text-align: center;
        }

        .text-red {
            color: #ff1300;
        }

        * {
            color: white;
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

        .hover-red:hover .material-symbols-outlined {
            color: red;
        }

        #navbar {
            background-color: transparent;
        }

        #navbar-logo {
            width: 70px;
            height: 70px;
            background-image: url('/f1_project/assets/images/F1.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .nav-profile{
            height: 85vh;
        }

        .profile-img{
            border-radius: 50%;
            width: 24px;
            height: 24px;
        }

    </style>

</head>

<body class="vh-100 bg-dark">
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php
[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);

    (isset($_GET["id"]) && $_GET["id"] != null)?$id = $_GET["id"]: $id = null;

    $element = choose_correct_data($id);
    unset($id);

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
    error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>


