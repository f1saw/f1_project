<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>
    <meta charset="UTF-8">
    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
    <style>
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

        #bg-register {
            background: url("/f1_project/images/FVCyg1fWIAIy8y7.jpeg");
            background-size: cover;
            background-position: top;
        }

        #bg-register #register-form {
            background: rgba(87, 87, 87, .6);
            backdrop-filter: blur(5px);
        }

        #bg-login {
            background: url("/f1_project/images/wp9002050-4k-f1-desktop-wallpapers.jpg");
            background-size: cover;
            background-position: bottom;
        }

        #bg-login #login-form {
            background: rgba(87, 87, 87, .6);
            backdrop-filter: blur(5px);
        }
    </style>

</head>

<body>
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php
[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    if(!isset($_GET["id"]) && $_GET["id"] == null) {
        error("401", " Unauthorized access.", "user_detail.php", "/f1_project/views/private/dashboard.php", "No user select.");
        exit;
    }

    $conn = DB::connect();
    $element = DB::get_record_by_field($conn,
        "SELECT first_name, last_name, img_url, role FROM Users WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "user_detail.php",
        "/f1_project/views/private/user_detail.php")[0];
    if (!$conn->close()) {
        error("500", "conn_close()", "user_detail.php", "/f1_project/views/private/dashboard.php");
        exit;
    }
    if($element != null) {
    ?>
        <div id="bg-login" class="container-fluid h-100 w-100 d-flex flex-column justify-content-center align-items-center">
            <div id="login-form" class="container col-12 col-md-6 col-lg-4 col-xl-3 py-3 border border-3 border-danger rounded">
                <div class="d-flex justify-content-center align-items-center">
                    <img class="rounded-circle" style="width: 70px; height: 70px;" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/images/default_img_profile.jpeg"; ?>"
                         alt="profile picture">
                </div>
            </div>
        </div>


        <!--
        <main class="container-fluid vh-100 w-100 d-flex flex-column justify-content-center align-items-center">
            <img class="rounded-circle" style="width: 70px; height: 70px;" src="<?php //if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/images/default_img_profile.jpeg"; ?>"
                 alt="profile picture">
            <div style="width: 40%;">
                <form method="post" id="edit_form" action="/f1_project/views/private/edit_user.php">
                    <table class="table">
                        <thead class="table-info">
                        <tr>
                            <th style="width: 30%; position: relative" scope="col">#</th>
                            <th style="width: 1%; position: relative" scope="col">Information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Firstname</th>
                            -->
                            <!--if(non premo bottone edit) then mostra nome else mostra input-->
                            <!-- <td> <?php //echo $element['first_name']; ?> </td> -->
        <!--
                            <td>
                                <label for="edit_firstname"></label>
                                <input type="text" name="edit_firstname" id="edit_firstname" placeholder="<?php //echo $element['first_name'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Lastname</th>
                            -->
                            <!-- <td> <?php //echo $element['last_name']; ?> </td> -->
        <!--
                            <td>
                                <label for="edit_lastname"></label>
                                <input type="text" name="edit_lastname" id="edit_lastname" placeholder="<?php //echo $element['last_name'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            -->
                            <!-- <td> <?php //echo $element['img_url']; ?> </td> -->
        <!--
                            <td>
                                <label for="edit_img"></label>
                                <input type="text" name="edit_img" id="edit_img" placeholder="<?php //echo $element['img_url'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Role</th>
                            -->
                            <!-- <td> <?php //echo $element['role']; ?> </td> -->
        <!--
                            <td>
                                <label for="edit_role"></label>
                                <input type="text" name="edit_role" id="edit_role" placeholder="<?php //echo $element['role'] ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="container-fluid d-flex justify-content-end">
                        <a href="/f1_project/views/private/dashboard.php"> <button style="position: relative; right: 20px" type="button" class="btn btn-primary">Home</button></a>
                        <button type="submit" name="Button" class="btn btn-light" value="<?php //echo $_GET["id"] ?>">Confirm</button>
                    </div>
                </form>
            </div>
        </main>
        -->
<?php
    }
    else
        // tmp
        echo "no information";
}
else{
    error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>
