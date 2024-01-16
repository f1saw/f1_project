<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once ("controllers/Drivers/drivers.php");
require_once ("controllers/Drivers/info_drivers.php");
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
                (provided by <a href="https://www.formula1.com/en/drivers.html" target="_blank" class="text-info text-decoration-none">formula1.com</a>)
            </span>
        <?php echo_drivers_cards($name_list, $lastname_list, $flag_list, $number_list, $img_list, $json_info_link,COL_CARD); ?>
    </main>
</div>

<script src="/f1_project/assets/js/info_drivers.js"></script>
</body>
</html>


