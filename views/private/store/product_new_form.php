<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | User</title>
    <meta charset="UTF-8">
    <!--modificare la navbar-->
    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/product_new.css">

    <?php if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
        error("500", "set_include_path()"); ?>

    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php"); ?>
    <?php require_once("utility/error_handling.php"); ?>
    <?php require_once ("DB/DB.php"); ?>
    <?php require_once("views/partials/alert.php") ?>
</head>

<body class="vh-100 bg-dark">
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php [$login_allowed, $user] = check_cookie(); ?>
<?php if (check_admin_auth($user)) {
    set_session($user); ?>

    <?php include("views/partials/navbar.php") ?>

    <div class="container-fluid row d-flex flex-row justify-content-center align-items-center gap-3 mt-5">

        <div class="col-12 col-sm-7">
            <form id="login-form" action="/f1_project/views/private/store/product_new.php" class="container" method="POST">

                <?php err_msg_alert(); ?>
                <?php succ_msg_alert(); ?>

                <fiedlset>
                    <legend class="d-flex align-items-center justify-content-start gap-2 hover-red">
                        <h1>PRODUCT (</h1>
                        <span class="material-symbols-outlined">add</span><h1>)</h1>
                    </legend>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="title" class="form-label"><strong>TITLE</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="title-addon">title</span>
                                <input type="text" id="title" class="form-control" name="title" placeholder="Title" aria-describedby="title-addon" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="desc" class="form-label"><strong>DESCRIPTION</strong></label>
                            <textarea class="form-control" id="desc" name="desc" rows="2" placeholder="Describe the product" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="price" class="form-label"><strong>PRICE</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="price-addon">euro</span>
                                <input type="text" id="price" class="form-control" name="price" placeholder="50.00" aria-describedby="price-addon" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="team" class="form-label"><strong>TEAM</strong></label>
                            <select name="team_id" id="team_id" class="form-select rounded" aria-label="Select size">
                                <option value="ns" class="option_invalid" selected disabled>Select team</option>
                                <option value="alfa_romeo" class="option_valid">Alfa Romeo</option>
                                <option value="alpha_tauri" class="option_valid">Alpha Tauri</option>
                                <option value="ferrari" class="option_valid">Ferrari</option>
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
                                <input type="text" id="size" class="form-control" name="size" placeholder="Size" aria-describedby="size-addon" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label style="width: fit-content" class="form-label mx-1 d-flex align-items-center justify-content-start gap-2" for="color" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="bottom" title="<strong>Blank space</strong> to separate<br>(eg. Red Orange Black)">
                                <strong>COLOR</strong>
                                <span class="material-symbols-outlined" style="color: aqua;">help</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="color-addon">palette</span>
                                <input type="text" id="color" class="form-control" name="color" placeholder="Color" aria-describedby="color-addon" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="img_url_1" class="form-label"><strong>IMAGE (1)</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="img-1-addon">image</span>
                                <input type="text" id="img_url_1" class="img_url form-control" name="img_url_1" placeholder="https://image.url" aria-describedby="img-1-addon" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="img_url_2" class="form-label"><strong>IMAGE (2)</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="img-2-addon">image</span>
                                <input type="text" id="img_url_2" class="img_url form-control" name="img_url_2" placeholder="https://image.url" aria-describedby="img-2-addon" required>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row col-12 d-flex justify-content-end align-items-center mx-1 gap-3">
                        <button type="submit" class="btn-reverse-color btn btn-danger col-12 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">
                            <span class="material-symbols-outlined">add</span>
                            <strong>Create</strong>
                        </button>
                        <a href="/f1_project/views/private/dashboard.php" class="my_outline_animation col-12 col-sm-3 text-center text-white text-decoration-none d-flex align-items-center justify-content-center gap-1 p-2 hover-red">
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
<?php } else {
    error("401", "not_authorized", "dashboard.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
} ?>

<script src="/f1_project/assets/js/tooltip.js"></script>
<script src="https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
<script src="/f1_project/assets/js/store.js"></script>
</body>
</html>