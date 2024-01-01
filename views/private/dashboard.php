<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once ("DB/DB.php");

[$login_allowed, $user] = check_cookie();
if(!check_user_auth($user)){
    $_SESSION['redirection'] = "/f1_project/views/private/dashboard.php";
    error("401", "not_authorized", "dashboard.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <?php include("views/partials/head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/private/dashboard_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
</head>

<body class="bg-dark">
    <div class="container-fluid">
        <?php include ("views/partials/navbar.php"); ?>
        <main>
            <div class="flex-container">
                <div class="flex-slide profile">
                    <div class="flex-title flex-title-profile">Profile</div>
                    <div onclick="goToProfile()" class="flex-about"><p class="text-center">Click here to view or edit your profile</p></div>
                </div>

                <?php if (check_admin_auth($user)) { ?>
                    <div class="flex-slide table-users">
                        <div class="flex-title">Table</div>
                        <div onclick="goToTable()" class="flex-about mb-2"><p class="text-center">Click here to view all users</p></div>
                        <div onclick="goToStoreManagement()" class="flex-about mt-2"><p class="text-center">Click here to manage the store</p></div>
                    </div>
                <?php } ?>

                <div class="flex-slide product">
                    <div class="flex-title flex-title-product">Orders</div>
                    <div onclick="goToOrders()" class="flex-about"><p class="text-center">Click here to view your orders</p></div>
                </div>
            </div>
        </main>
    </div>

    <script src="/f1_project/assets/js/dashboard_script.js"></script>
</body>
</html>