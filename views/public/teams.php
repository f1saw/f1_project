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
    <title>Teams</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/info_cards.css">
    <?php include("views/partials/head.php"); ?>
</head>

<body class="bg-dark">
<div class="container-fluid">

    <!-- Nav -->
    <?php include ("views/partials/navbar.php");?>

    <main>
        <br>
        <div class="d-flex justify-content-between align-items-center">
            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-start align-items-center">
                    <button type="button" id="drivers" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red switch-page"><span class="material-symbols-outlined">chevron_left</span></button>
                    <span class="left_element">2024 Drivers</span>
                </span>
            </div>


            <div class="text-light margin h2 d-flex justify-content-start align-items-center">
                    <span class="central_element">2024 Teams</span>
            </div>

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-end align-items-center">
                    <span class="right_element">2023 Statistics</span>
                    <button type="button" id="statistics" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red switch-page"><span class="material-symbols-outlined">chevron_right</span></button>
                </span>
            </div>
        </div>
        <?php echo_teams_cards($name_list, $lastname_list, $team_list, $img_list, COL_CARD); ?>
    </main>
</div>

<script src="/f1_project/assets/js/navigate.js"></script>
</body>
</html>



