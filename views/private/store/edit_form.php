<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

include("views/partials/head.php");
require_once("auth/auth.php");
require_once("utility/error_handling.php");
require_once ("utility/store.php");
require_once ("DB/DB.php");
require_once("views/partials/alert.php");

if(session_status() == PHP_SESSION_NONE) session_start();

[$login_allowed, $user] = check_cookie();
if (!check_admin_auth($user)) {
    $_SESSION['redirection'] = "/f1_project/views/private/store/edit_form.php";
    error("401", "not_authorized", "store/edit_form.php", "/f1_project/views/public/login_form.php", "Unauthorised access.");
    exit;
}
set_session($user);

if (!isset($_GET["id"]) || !$_GET["id"]) {
    error("500", "product_id_not_specified", "store/edit_form.php", "/f1_project/views/private/store/all.php", "PRODUCT ID NOT specified.");
    exit;
}

$id = intval($_GET["id"])?? -1;
$conn = DB::connect("store/edit_form.php", "f1_project/views/private/store/all.php");
$product = DB::get_record_by_field($conn,
    "SELECT Products.id AS 'Products.id', Products.title AS 'Products.title', Products.description AS 'Products.description', Products.price AS 'Products.price', Products.size AS 'Products.size', Products.color AS 'Products.color', Products.img_url AS 'Products.img_url', Teams.id AS 'Teams.id', Teams.name AS 'Teams.name' 
            FROM Products JOIN Teams ON Products.team_id = Teams.id WHERE Products.id = ?;",
    ["i"],
    [$id],
"store/edit_form.php",
"/f1_project/views/private/store/all.php")[0];

if (!$conn->close()) {
    error("500", "conn_close()", "store/edit_form.php", "/f1_project/views/private/store/all.php");
    exit;
}
if (!$product) {
    error("500", "product_look_up", "store/edit_form.php", "/f1_project/views/private/store/all.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en" >
<head>
    <title><?php echo $product["Products.title"] ?></title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/product_new.css">
</head>

<body class="vh-100 bg-dark">
    <div class="container-fluid">
        <?php include("views/partials/navbar.php") ?>

        <div class="container-fluid row d-flex flex-row justify-content-center align-items-center gap-3 mt-5">

            <div class="col-12 col-md-10">

                <form action="/f1_project/controllers/store/edit.php" method="POST" class="container col-12 col-xl-6 py-3 border border-3 border-danger rounded">

                    <?php err_msg_alert(); ?>

                    <fiedlset>
                        <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                            <span class="material-symbols-outlined">edit_note</span>
                            <b>EDIT</b> (<?php echo (strlen($product["Products.title"]) < 20)? $product["Products.title"] : (substr($product["Products.title"], 0 , 20) . " [...]") ?>)
                        </legend>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="title" class="form-label"><strong>TITLE</strong></label><br>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="title-addon">title</span>
                                    <input type="text" id="title" class="form-control" name="title" placeholder="Title" value="<?php echo $product["Products.title"] ?>" aria-describedby="title-addon" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="desc" class="form-label"><strong>DESCRIPTION</strong></label>
                                <textarea class="form-control" id="desc" name="desc" rows="2" placeholder="Description" required><?php echo $product["Products.description"]; ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="price" class="form-label"><strong>PRICE</strong></label><br>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="price-addon">euro</span>
                                    <?php [$int, $dec] = str2int_dec($product["Products.price"]); ?>
                                    <input type="text" id="price" class="form-control" name="price" placeholder="50.00" value="<?php echo $int . "." . $dec; ?>" aria-describedby="price-addon" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <?php
                                $conn = DB::connect("store/edit_form.php", "/f1_project/views/private/store/all.php");
                                [$num_teams, $teams] = DB::stmt_get_record_by_field($conn,
                                    "SELECT * FROM Teams;",
                                    "store/edit_form.php",
                                    "/f1_project/views/private/store/all.php");
                                if (!$conn->close()) {
                                    error("500", "conn_close()", "store/edit_form.php", "/f1_project/views/private/store/all.php");
                                    exit;
                                }
                                ?>

                                <?php echo $product["Teams.id"]; ?>
                                <label for="team" class="form-label"><strong>TEAM</strong></label>
                                <select name="team_id" id="team_id" class="form-select rounded" aria-label="Select size">
                                    <option value="ns" class="option_invalid" selected disabled>Select team</option>
                                    <?php
                                    foreach ($teams as $team) {
                                        echo "<option value=" . $team["id"] . " class='option_valid' " . (($team["id"] == $product["Teams.id"])? " selected":"") . ">" . $team["name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label style="width: fit-content" class="form-label mx-1 d-flex align-items-center justify-content-start gap-2" for="size" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<strong>Blank space</strong> to separate<br>(eg. XS S M L XL)">
                                    <strong>SIZE</strong>
                                    <span class="material-symbols-outlined" style="color: aqua;">help</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="size-addon">sell</span>
                                    <input type="text" id="size" class="form-control" name="size" value="<?php echo strtoupper($product["Products.size"]) ?>" placeholder="Size" aria-describedby="size-addon" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label style="width: fit-content" class="form-label mx-1 d-flex align-items-center justify-content-start gap-2" for="color" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<strong>Blank space</strong> to separate<br>(eg. Red Orange Black)">
                                    <strong>COLOR</strong>
                                    <span class="material-symbols-outlined" style="color: aqua;">help</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="color-addon">palette</span>
                                    <input type="text" id="color" class="form-control" name="color" value="<?php echo $product["Products.color"] ?>" placeholder="Color" aria-describedby="color-addon" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">

                            <?php
                            [$img1, $img2] = "";
                            if ($product["Products.img_url"] != "") {
                                $img1 = explode("\t", $product["Products.img_url"])[0];
                                $img2 = explode("\t", $product["Products.img_url"])[1];
                            }
                            ?>

                            <div class="col-6">
                                <label for="img_url_1" class="form-label"><strong>IMAGE (1)</strong></label><br>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="img-1-addon">image</span>
                                    <input type="text" id="img_url_1" class="img_url form-control" name="img_url_1" value="<?php echo $img1 ?>" placeholder="https://image.url" aria-describedby="img-1-addon">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="img_url_2" class="form-label"><strong>IMAGE (2)</strong></label><br>
                                <div class="input-group">
                                    <span class="input-group-text material-symbols-outlined text-dark" id="img-2-addon">image</span>
                                    <input type="text" id="img_url_2" class="img_url form-control" name="img_url_2" value="<?php echo $img2 ?>" placeholder="https://image.url" aria-describedby="img-2-addon">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row col-12 d-flex justify-content-end align-items-center mx-1 gap-3">
                            <button type="submit" class="btn-reverse-color btn btn-danger col-12 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                                <span class="material-symbols-outlined">add</span>
                                <strong>Update</strong>
                            </button>
                            <a href="/f1_project/views/private/store/all.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
                                <span class="material-symbols-outlined">fast_rewind</span>
                                <span class="d-inline d-sm-none d-xxl-inline">Discard</span>
                            </a>
                        </div>
                    </fiedlset>

                </form>


            </div>

            <div id="img-preview" class="d-none col-12 col-sm-5 row">
                <img id="img-url-1" class="d-none img-url col-6 rounded" alt="..." src="">
                <img id="img-url-2" class="d-none img-url col-6 rounded " alt="..." src="">
            </div>
            <!-- TODO: just for testing -->
            <?php session_destroy(); ?>
        </div>
    </div>

    <script src="/f1_project/assets/js/tooltip.js"></script>
    <script src="https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
    <script src="/f1_project/assets/js/store.js"></script>
</body>
</html>