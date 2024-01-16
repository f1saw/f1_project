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

    <?php include("views/partials/head.php"); ?>

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
        <div class="container-fluid" >
            <?php include("views/partials/navbar.php"); ?>
            <main >
                <div id="bg-profile" class="flex-container d-flex justify-content-center" >
                    <div id="profile-data" class="container-element">
                        <div style="margin-left: 10px; margin-right: 10px">
                            <?php $function = "var x = document.getElementsByClassName('container-element')[0];
                                       x.style.height = '480px';
                                       x.style.top    = '100px';" ?>
                            <?php err_msg_alert($function); ?>
                            <?php succ_msg_alert($function); ?>
                        </div>
                        <div class="d-flex justify-content-center">
                            <img id="photo_profile" class="rounded-circle" src="<?php if($element["img_url"] != null) echo htmlentities($element['img_url']); else echo "/f1_project/assets/images/default_img_profile.jpeg"; ?>"
                                 alt="profile picture">
                        </div>
                        <br>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="col-12">
                                    <span class="d-flex justify-content-center">
                                        <label class="form-label"><strong class=" text-red">Firstname</strong></label><br>
                                    </span>
                                    <div class="input-group d-flex text-center">
                                        <label class="form-control text-box" ><?php ($element["first_name"] != "")?print htmlentities($element["first_name"]): print "No element";?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label class="form-label"><strong class="text-red">Lastname</strong></label><br>
                            </span>
                                    <div class="input-group d-flex text-center">
                                        <label class="form-control text-box" ><?php ($element["last_name"] != "")?print htmlentities($element["last_name"]): print "No element"; ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                        <span class="d-flex justify-content-center">
                            <label class="form-label"><strong class="text-red">Email</strong></label><br>
                        </span>
                                <div class="input-group d-flex text-center">
                                    <label class="form-control text-box"><?php ($element["email"] != "")?print htmlentities($element["email"]): print "No element"; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label class="form-label"><strong class="text-red">Date of birth</strong></label><br>
                            </span>
                                    <div class="input-group d-flex text-center">
                                        <label class="form-control text-box" ><?php ($element["date_of_birth"] != "")?print htmlentities($element["date_of_birth"]): print "No element"; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label class="form-label"><strong class="text-red">Remember me</strong></label><br>
                            </span>
                                    <div class="input-group d-flex text-center">
                                        <label class="form-control text-box" ><?php ($element["cookie_id"] != null)? print "Active": print "Not Active" ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="button_div" class="row mb-3 d-flex justify-content-center button">
                            <button onclick="my_function()" type="button" class="btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Edit profile</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script>
            function my_function(){
                window.open("/f1_project/edit_profile.php/?id=<?php echo htmlentities($element["id"]); ?>","_self");
            }
        </script>

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