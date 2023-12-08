<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Dashboard </title>

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>

    <link rel="stylesheet" href="../../assets/css/dashboard_style.css">
    <link rel="stylesheet" href="../../assets/css/style.css">

    <?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

    <?php
    [$login_allowed, $user] = check_cookie();
    if(check_admin_auth($user))
        echo '<link rel="stylesheet" href="../../assets/css/dashboard_style_admin.css">';
    else
        echo '<link rel="stylesheet" href="../../assets/css/dashboard_style_users.css">'
    ?>
</head>
<body class="bg-dark">
    <?php if(check_admin_auth($user)){?>
        <div class="container-fluid">
            <?php include ("../partials/navbar.php"); ?>
            <main>
                <div class="flex-container">
                    <div class="flex-slide profile display-flex">
                        <div class="flex-title flex-title-profile">Profile</div>
                        <div onclick="goToProfile()" class="flex-about"><p class="text-center">Click here to view or edit your profile</p></div>
                    </div>

                    <div class="flex-slide table-users">
                        <div class="flex-title">Table</div>
                        <div onclick="goToTable()" class="flex-about"><p class="text-center">Click here to view all users</p></div>
                    </div>

                    <div class="flex-slide product">
                        <div class="flex-title flex-title-product">Orders</div>
                        <div onclick="goToOrders()" class="flex-about"><p class="text-center">Click here to view your orders</p></div>
                    </div>
                </div>
            </main>
        </div>
        <script src="../../assets/js/dashboard_script.js"></script>s

    <?php
    }
    else if (check_user_auth($user)) {?>
        <div class="container-fluid">
            <?php include ("../partials/navbar.php"); ?>
            <main>
                <div class="flex-container">
                    <div class="flex-slide profile">
                        <div class="flex-title flex-title-profile">Profile</div>
                        <div onclick="goToProfile()" class="flex-about"><p class="text-center">Click here to view or edit your profile</p></div>
                    </div>

                    <div class="flex-slide product">
                        <div class="flex-title">Orders</div>
                        <div onclick="goToOrders()" class="flex-about"><p class="text-center">Click here to view your orders</p></div>
                    </div>
                </div>
            </main>
        </div>
        <script src="../../assets/js/dashboard_script.js"></script>s
    <?php
    }else{
        $_SESSION['redirection'] = "/f1_project/views/private/dashboard.php";
        error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
        exit;
    }
?>
</body>
</html>

