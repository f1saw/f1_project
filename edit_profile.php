<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if (session_status() == PHP_SESSION_NONE) session_start();

require_once("views/partials/alert.php");
require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("utility/utility_func.php");
require_once("DB/DB.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>
    <meta charset="UTF-8">

    <?php include ("views/partials/head.php"); ?>
    <?php include ("views/partials/toggle_head.php"); ?>

    <link rel="stylesheet" href="/f1_project/assets/css/private/profile_style.css">
</head>

<?php if(isset($_SESSION["err"]) && $_SESSION["err"] || isset($_SESSION["success"]) && $_SESSION["success"]){ ?>
<style>
    .container-element{
        height: 550px;
        top: 55px;
    }
</style>
<?php } ?>

<body class="bg-dark">

<?php
// TODO error_redirector, link ai css non funzionano, why??
[$login_allowed, $user] = check_cookie();
if (check_user_auth($user)) {
    set_session($user);

    if(check_admin_auth($user)) {
        (isset($_GET["id"]) && $_GET["id"] != null) ? $id = $_GET["id"] : $id = null;
        $element = select_user($id);
        unset($id);
    }
    else{
        $element = select_user(null);
    }
    if($element != null) {
    ?>

        <?php
        if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
            error("500", "set_include_path()");
        if(session_status() == PHP_SESSION_NONE) session_start();

        require_once("controllers/auth/auth.php");

        [$login_allowed, $user] = check_cookie();
        if(!check_user_auth($user)){
            $_SESSION['redirection'] = "/f1_project/views/private/partials/user_detail_show_profile.php";
            error("401", "not_authorized", "dashboard.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
            exit;
        }
        ?>

        <?php
        if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
            error("500", "set_include_path()");
        if(session_status() == PHP_SESSION_NONE) session_start();

        require_once("controllers/auth/auth.php");

        [$login_allowed, $user] = check_cookie();
        if(!check_user_auth($user)){
            $_SESSION['redirection'] = "/f1_project/views/private/partials/user_detail_edit_profile.php";
            error("401", "not_authorized", "dashboard.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
            exit;
        }
        ?>
        <div class="container-fluid">
            <?php include("views/partials/navbar.php"); ?>
            <main>
                <div id="bg-profile" class="flex-container d-flex justify-content-center">
                    <form id="profile-data" class="container-element" enctype="multipart/form-data" method="POST" action="/f1_project/update_profile.php/?my_profile=<?php (isset($_GET["my_profile"]) && $_GET["my_profile"] == 1)?print 1: print 0 ?>">
                        <div id="page1">
                            <div class="d-flex justify-content-center">
                                <img id="photo_profile" class="rounded-circle" src="<?php if($element['img_url'] != null) echo htmlentities($element['img_url']); else echo "/f1_project/assets/images/default_img_profile.jpeg"; ?>"
                                     alt="<?php echo ($element["first_name"]? htmlentities($element["first_name"]):"") . " Profile picture"; ?>">
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <div class="col-12">
                                <span class="d-flex justify-content-center">
                                    <label for="firstname" class="form-label"><strong class="text-red">Firstname</strong></label><br>
                                </span>
                                        <div class="input-group">
                                            <input type="text" id="firstname" name="firstname" class="form-control text-box" placeholder="<?php echo htmlentities($element["first_name"]); ?>">
                                        </div>
                                        <div id="input-info-firstname" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="col-12">
                                <span class="d-flex justify-content-center">
                                    <label for="lastname" class="form-label"><strong class="text-red">Lastname</strong></label><br>
                                </span>
                                        <div class="input-group d-flex text-center">
                                            <input type="text" id="lastname" name="lastname" class="form-control text-box" placeholder="<?php echo $element["last_name"]; ?>">
                                        </div>
                                        <div id="input-info-lastname" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <span class="d-flex justify-content-center">
                                        <label for="email" class="form-label"><strong class="text-red">Email</strong></label><br>
                                    </span>
                                    <div class="input-group d-flex text-center">
                                        <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){ ?>
                                            <label class="form-control text-box"><?php echo htmlentities($element["email"]); ?></label>
                                        <?php } else {?>
                                            <input type="text" id="email" name="email" pattern='^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$' class="form-control text-box" placeholder="<?php echo htmlentities($element["email"]); ?>" >
                                        <?php } ?>
                                    </div>
                                    <div class="text-box d-flex gap-2 mt-1 py-1">
                                        <span id="status_symbol" style="display: none" class="material-symbols-outlined text-danger">warning</span>
                                        <span id="status" class="text-danger"></span>
                                    </div>
                                    <div id="input-info-email" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                        <span class="material-symbols-outlined"></span>
                                        <span class=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-12 col-md-6">
                                    <span class="d-flex justify-content-center">
                                        <label for="edit_date_of_birth" class="form-label"><strong class="text-red">Date of birth</strong></label><br>
                                    </span>
                                    <div class="input-group d-flex text-center">
                                        <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]) { ?>
                                            <label class="form-control text-box"><?php ($element["date_of_birth"] != null)? print $element["date_of_birth"]: print "No element"; ?></label>
                                        <?php } else {?>
                                            <input type="date" id="edit_date_of_birth" name="edit_date_of_birth" class="form-control text-box" >
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                            <span class="d-flex justify-content-center">
                                <label for="edit_news" class="form-label"><strong class="text-red">Newsletter</strong></label><br>
                            </span>
                                    <div class="input-group d-flex text-center">
                                        <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]) { ?>
                                            <label class="form-control text-box"><?php ($element["newsletter"] != null)? print $element["newsletter"]: print "No element"; ?></label>
                                        <?php } else {?>
                                            <input type="number" id="edit_news" name="edit_news" class="form-control text-box" placeholder="Active: 1  Inactive: 0">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div id="button_div" class="row mb-3 d-flex justify-content-center button">
                                <button type="button" name="other_info_back" style="border: unset" class="navigate-left navigate btn btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_left</span></button>

                                <button type="submit" id="btn-submit" name="Button_id" value="<?php echo htmlentities($_GET["id"]); ?>" class="btn-submit btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Confirm</button>
                              
                                <button type="button" name="other_info_next" onclick="next_page()" style="border: unset" class="navigate-right navigate btn btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_right</span></button>
                            </div>
                        </div>

                        <div id="page2" style="display: none">
                            <div class="d-flex justify-content-center">
                                <img id="photo_profile" class="rounded-circle" src="<?php if($element['img_url'] != null) echo htmlentities($element['img_url']); else echo "/f1_project/assets/images/default_img_profile.jpeg"; ?>"
                                     alt="profile picture">
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <div class="col-12">
                                        <span class="d-flex justify-content-center">
                                            <label for="pass" class="form-label"><strong class="text-red">Password</strong></label><br>
                                        </span>
                                        <div class="input-group d-flex text-center">
                                            <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]) { ?>
                                                <label class="form-control text-box">Not allowed</label>
                                            <?php } else {?>
                                                <input type="password" id="pass" name="pass" class="form-control text-box" placeholder="password">
                                            <?php } ?>
                                        </div>
                                        <div id="input-info-pass" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="col-12">
                                        <span class="d-flex justify-content-center">
                                            <label for="pass-confirm" class="form-label"><strong class="text-red">Confirm password</strong></label><br>
                                        </span>
                                        <div class="input-group d-flex text-center">
                                            <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]) { ?>
                                                <label class="form-control text-box">Not allowed</label>
                                            <?php } else {?>
                                                <input type="password" id="pass-confirm" name="confirm" class="form-control text-box" placeholder="confirm password">
                                            <?php } ?>
                                        </div>
                                        <div id="input-info-pass-confirm" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row mb-3 d-flex align-items-center">

                                <!-- LOCAL UPLOAD IMAGE -->
                                <div class="row mb-3 d-none col-9" id="image-local-div">
                                    <div class="col-12">
                                        <span class="d-flex justify-content-center">
                                            <label for="image-local" class="form-label"><strong class="text-danger">UPLOAD IMAGE</strong></label><br>
                                        </span>
                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image-local" name="image-local">

                                        <div id="input-info-image-local" class="d-none d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- WEB UPLOAD IMAGE -->
                                <div class="row mb-3 col-9" id="image-url-div">
                                    <div class="col-12">
                                        <span class="d-flex justify-content-center">
                                            <label for="img_url" class="form-label"><strong class="text-red">Url img</strong></label><br>
                                        </span>
                                        <div class="input-group d-flex text-center">
                                            <input type="text" id="img_url" name="edit_img" class="form-control text-box" placeholder="<?php echo htmlentities($element["img_url"]); ?>">
                                        </div>
                                        <div id="input-info-img_url" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                            <span class="material-symbols-outlined"></span>
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label class="checkbox-inline" for="choose-file-upload"></label>
                                    <input type="checkbox" id="choose-file-upload" data-toggle="toggle" data-on="Local" data-off="URL" data-onstyle="danger" data-offstyle="border border-danger">
                                </div>
                            </div>









                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                <span class="d-flex justify-content-center">
                                    <label for="edit_remember_me" class="form-label"><strong class="text-red">Remember me</strong></label><br>
                                </span>
                                    <div class="input-group d-flex text-center">
                                        <label class="form-control text-box"><?php ($element["cookie_id"] != null)? print "Active": print "Inactive"; ?></label>
                                    </div>
                                </div>
                                <div class="col 12 col-md-6">
                            <span class="d-flex justify-content-center">
                                <label for="edit_role" class="form-label"><strong class=" text-red">role</strong></label><br>
                            </span>
                                    <div class="input-group d-flex text-center">
                                        <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){?>
                                            <input type="number" id="edit_role" name="edit_role" class="form-control text-box" placeholder="<?php echo htmlentities($element["role"]); ?>">
                                        <?php } else{ ?>
                                            <label class="form-control text-box"> <?php ($_SESSION["role"] == 1)? print "Admin": print "User"; ?> </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div id="button_div" class="row mb-3 d-flex justify-content-center button">
                                <button type="button" name="other_info" onclick="last_page()" style="border: unset" class="navigate-left navigate btn btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_left</span></button>
                                <button type="submit" name="Button_id" value="<?php echo htmlentities($element["id"]); ?>" class="btn-submit btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Confirm</button>
                                <button type="button" name="other_info" style="border: unset" class="navigate-right btn navigate btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_right</span></button>
                            </div>
                        </div>

                        <!-- Loading circle -->
                        <?php include("views/partials/loading.php"); ?>
                    </form>
                </div>
            </main>
        </div>

        <script src="/f1_project/assets/js/validators/user.js"></script>
        <script src="/f1_project/assets/js/users/edit.js"></script>
        <script src="/f1_project/assets/js/image_upload.js"></script>

        <?php
        //if (isset($_GET["edit"]) && $_GET["edit"] == 1) {
        //  include("views/private/partials/user_detail_edit_profile.php");
        //} else {
        //  include("views/private/partials/user_detail_show_profile.php");
        //}
    }
    else{
        error("500", "User is NULL", "\\views\users\show_profile.php", "/f1_project/views/private/dashboard.php");
    }
}
else{
    $_SESSION['redirection'] = "/f1_project/show_profile.php?id={${${$_GET['id']??''}}}";
    error("401", "not_authorized", "\\views\users\show_profile.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>