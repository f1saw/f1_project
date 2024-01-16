<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once ("controllers/teams/teams.php");
require_once ("views/partials/public/teams_card.php");
require_once("controllers/auth/auth.php");

const COL_CARD = "col-12 col-sm-6 col-lg-4 col-xl-3";

[$name_list, $lastname_list, $team_list, $img_list] = f1_scrape_teams(BASE_URL_TEAMS);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Drivers</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/news.css">
    <?php include("views/partials/head.php"); ?>
</head>

<body class="bg-dark">
<div class="container-fluid">

    <!-- Nav -->
    <?php include ("views/partials/navbar.php");?>

    <main>
        <br>
        <span class="title text-light">
                <span class="text-light h2">
                    2024 Drivers
                    <span class="material-symbols-outlined text-danger">download</span>
                </span>
                (provided by <a href="https://www.formula1.com/en/teams.html" target="_blank" class="text-info text-decoration-none">formula1.com</a>)
            </span>
        <?php echo_teams_cards($name_list, $lastname_list, $team_list, $img_list, COL_CARD); ?>
    </main>
</div>

<script src="/f1_project/assets/js/info_drivers.js"></script>
</body>
</html>



