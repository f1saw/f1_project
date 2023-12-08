<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | User</title>
    <meta charset="UTF-8">
    <!--modificare la navbar-->
    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/index_style.css">

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

    <div class="container-fluid d-flex flex-row justify-content-center align-items-center gap-4 mt-5">

        <div class="col-6 col-md-6">


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
                        <div class="col-12">
                            <label for="price" class="form-label"><strong>PRICE</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="price-addon">euro</span>
                                <input type="text" id="price" class="form-control" name="price" placeholder="50.00" aria-describedby="price-addon" required>
                            </div>
                        </div>
                    </div>


                    <style>
                        select .option_invalid {
                            background-color: rgb(200,200,200) !important;
                        }
                        select .option_valid {
                            color: black !important;
                        }
                    </style>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="team" class="form-label"><strong>TEAM</strong></label>
                            <select name="team_id" id="team_id" class="form-select rounded" aria-label="Select size">
                                <option value="ns" class="option_invalid" selected disabled>Select team</option>
                                <option value="alfa_romeo" class="option_valid">Alfa Romeo</option>
                                <option value="alpha_tauri" class="option_valid">Alpha Tauri</option>
                                <option value="ferrari" class="option_valid">Ferrari</option>
                                <option value="xl" class="option_valid">XL</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="img_url" class="form-label"><strong>IMAGE</strong></label><br>
                            <div class="input-group">
                                <span class="input-group-text material-symbols-outlined text-dark" id="img-addon">image</span>
                                <input type="text" id="img_url" class="form-control" name="img_url" placeholder="https://image.url" aria-describedby="img-addon" required>
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

        <div id="img-preview" class="d-none col-4">
            <img id="img-act" src="" class="d-none card-img-top rounded" alt="...">
        </div>

        <!-- TODO: just for testing -->
        <?php session_destroy(); ?>
    </div>
<?php } else {
    error("401", "not_authorized", "dashboard.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
} ?>


<script src="https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
<script>
    $("#img_url").on('input', $.debounce(250, () => {
        const curr_url = $("#img_url").val()
        if (curr_url !== "") {
            $("#img-preview").removeClass("d-none")
            $("#img-act").removeClass("d-none").attr("src", curr_url)
        } else {
            $("#img-preview").addClass("d-none")
            $("#img-act").addClass("d-none")
        }
    }))
</script>

</body>
</html>