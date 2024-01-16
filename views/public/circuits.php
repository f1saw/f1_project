<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

$ini = parse_ini_file("config/keys.ini");

require_once ("views/partials/public/news_cards.php");
require_once("controllers/auth/auth.php");

const COL_CARD = "col-12 col-sm-6 col-lg-4 col-xl-3";

// const CALENDAR_URL = "https://en.wikipedia.org/wiki/2024_Formula_One_World_Championship";
//$circuits = f1_scrape_calendar(CALENDAR_URL);
// JSON to achieve accuracy in weather API location
$circuits = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "\controllers\calendar\circuits.json"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Calendar 2024</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/news.css">

    <?php include("views/partials/head.php"); ?>
</head>

<body class="bg-dark">
<div class="container-fluid">

    <!-- Nav -->
    <?php include ("views/partials/navbar.php");?>

    <script>
        const get_weather = async city => {
            city = city.replace(" ", "+")
            // console.log(city)
            const API_KEY = "<?php echo $ini["API_KEY"]; ?>";
            fetch(`http://api.openweathermap.org/geo/1.0/direct?q=${city}&limit=1&appid=${API_KEY}`)
                .then(response => response.json())
                .then(json => {
                    // console.log(json)
                    const lat = json[0]["lat"];
                    const lon = json[0]["lon"];

                    fetch(`https://api.openweathermap.org/data/3.0/onecall?lat=${lat}&lon=${lon}&appid=${API_KEY}`)
                        .then(response => response.json())
                        .then(json => {
                            // console.log(json)

                            // create a new Date object with the current date and time
                            const date = new Date();

                            // use the toLocaleString() method to display the date in different timezones
                            const localTime = date.toLocaleString(navigator.language, {
                                hour: '2-digit',
                                minute: '2-digit',
                                timeZone: json.timezone
                            });
                            // console.log(navigator.language + "\n" + localTime + " " + city + " " + json.timezone)

                            const weather = json.current.weather[0];
                            const temp = Math.round((json.current.temp - 273.15) * 10) / 10;
                            const img = `<img src='https://openweathermap.org/img/wn/${weather.icon}.png' alt="Weather icon">`;
                            $(`#curr-weather-${city.replace("+", "-")}-main`).html(`<strong>${weather.description.charAt(0).toUpperCase() + weather.description.slice(1)}</strong>`);
                            $(`#curr-weather-${city.replace("+", "-")}-icon`).html(`${img}`);
                            $(`#curr-weather-${city.replace("+", "-")}-temp`).html(`${temp} °C`);
                            $(`#curr-weather-${city.replace("+", "-")}-time`).html(`<strong>${localTime}</strong>`);
                        })
                        .catch(err => console.log(err))
                })
                .catch(err => console.log(err))
        }
    </script>

    <main>
        <br>
        <div class="d-flex justify-content-between align-items-center">

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-start align-items-center">
                    <button type="button" onclick="statistics()" style="border: unset; padding-left: 20px" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red"><span class="material-symbols-outlined">chevron_left</span></button>
                    <span style="font-size: 20px">2023 Statistics</span>
                </span>
            </div>

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-start align-items-center">
                    2024 Calendar
                </span>
            </div>

            <div class="title text-light">
                <span class="text-light h2 d-flex justify-content-start align-items-center"">
                <span style="font-size: 20px">2024 Drivers</span>
                <button type="button" onclick="drivers()" style="border: unset; padding-right: 20px" class="navigate-left navigate btn col-2 col-sm-2 col-md-1 d-flex justify-content-center hover-red"><span class="material-symbols-outlined">chevron_right</span></button>
                </span>
            </div>
        </div>

        <div class="row">
            <?php foreach ($circuits as $circuit) { ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 d-flex align-items-stretch py-3">
                    <div class="card border border-danger border-3 p-2 d-flex flex-column justify-content-between">
                        <div class="card-img">
                            <img style="height: 200px; width: 350px; object-fit: cover; " src="<?php echo htmlentities($circuit->img_url); ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body d-flex align-items-end">
                            <div class="w-100">
                                <div class="d-flex justify-content-between card-title">
                                    <h6 class="text-danger"><?php echo htmlentities($circuit->gp_name); ?></h6>
                                    <h6><?php echo htmlentities($circuit->race_date); ?></h6>
                                </div>
                                <div class="d-flex justify-content-between align-content-center">
                                    <div>
                                        <span id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-main"></span>
                                        <span id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-icon"></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="my-auto" id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-temp"></span>
                                        <span class="my-auto" id="curr-weather-<?php echo preg_replace("/\s/", "-", $circuit->circuit_place); ?>-time"></span>

                                    </div>
                                </div>
                                <hr>
                                <p class="card-text">
                                    Round: <?php echo "<strong>" . htmlentities($circuit->round) . "</strong>/" . count($circuits); ?>
                                    <br>
                                    Circuit name: <strong><?php echo htmlentities($circuit->circuit_name); ?></strong>
                                    <br>
                                    Location: <strong><?php echo htmlentities($circuit->circuit_place); ?></strong>
                                    <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    get_weather("<?php echo $circuit->circuit_place; ?>");
                </script>
            <?php } ?>
        </div>
    </main>
</div>
<script src="/f1_project/assets/js/navigate.js"></script>
</body>
</html>