<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/drivers/drivers.php");
require_once("controllers/drivers/info_drivers.php");
require_once ("views/partials/public/drivers_cards.php");
require_once("controllers/auth/auth.php");

const COL_CARD = "col-12 col-sm-6 col-lg-4 col-xl-3";

[$name_list, $lastname_list, $flag_list, $team_list, $number_list, $img_list] = f1_scrape_drivers(BASE_URL);
$json = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "\\views\\partials\\public\\driver_info_link.json");
$json_info_link = json_decode($json, true);
$info = ["Team", "Country", "Podiums", "Points", "Grands Prix entered", "World Championships",
    "Highest race finish", "Highest grid position", "Date of birth", "Place of birth"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Drivers</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/info_cards.css">
    <?php include("views/partials/head.php"); ?>
</head>

<script src="/f1_project/assets/js/info_drivers.js"></script>

<body class="bg-dark">
<div class="container-fluid">

    <!-- Nav -->
    <?php include ("views/partials/navbar.php");?>

    <main>
        <br>
        <div class="d-flex justify-content-between align-items-center">

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-start align-items-center">
                    <button type="button" id="circuits" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red switch-page"><span class="material-symbols-outlined">chevron_left</span></button>
                    <span class="left_element">2024 Circuits</span>
                </span>
            </div>

            <div class="text-light margin h2 d-flex justify-content-start align-items-center">
                <span class="central_element">2024 Drivers</span>
            </div>

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-end align-items-center">
                    <span class="right_element">2023 Teams</span>
                    <button type="button" id="teams" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red switch-page"><span class="material-symbols-outlined">chevron_right</span></button>
                </span>
            </div>

        </div>
        <?php echo_drivers_cards($name_list, $lastname_list, $flag_list, $number_list, $img_list, $json_info_link,COL_CARD); ?>
    </main>
</div>

<script src="/f1_project/assets/js/navigate.js"></script>

</body>
</html>


