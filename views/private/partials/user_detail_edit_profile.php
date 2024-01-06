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
            <form id="profile-data" class="container-element" method="POST" action="/f1_project/controllers/users/edit.php/?my_profile=<?php (isset($_GET["my_profile"]) && $_GET["my_profile"] == 1)?print 1: print 0 ?>">
                <div id="page1">
                    <div class="d-flex justify-content-center">
                        <img id="photo_profile" class="rounded-circle" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/assets/images/default_img_profile.jpeg"; ?>"
                             alt="profile picture">
                    </div>
                    <br>
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="col-12">
                                <span class="d-flex justify-content-center">
                                    <label for="edit_firstname" class="form-label"><strong class="text-red">Firstname</strong></label><br>
                                </span>
                                <div class="input-group">
                                    <input type="text" id="edit_firstname" name="edit_firstname" class="form-control text-box" placeholder="<?php echo $element["first_name"]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="col-12">
                                <span class="d-flex justify-content-center">
                                    <label for="edit_lastname" class="form-label"><strong class="text-red">Lastname</strong></label><br>
                                </span>
                                <div class="input-group d-flex text-center">
                                    <input type="text" id="edit_lastname" name="edit_lastname" class="form-control text-box" placeholder="<?php echo $element["last_name"]; ?>">
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
                                <label class="form-control text-box"><?php echo $element["email"] ?></label>
                                <?php } else {?>
                                <input type="text" id="email" name="edit_email" class="form-control text-box" placeholder="<?php echo $element["email"]; ?>" >
                                <?php } ?>
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
                                <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){ ?>
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
                                    <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){ ?>
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
                        <button type="submit" name="Button_id" value="<?php echo $_GET["id"]; ?>" class="btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Confirm</button>
                        <button type="button" name="other_info_next" onclick="next_page()" style="border: unset" class="navigate-right navigate btn btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_right</span></button>
                    </div>
                </div>

                <div id="page2" style="display: none">
                    <div class="d-flex justify-content-center">
                        <img id="photo_profile" class="rounded-circle" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/assets/images/default_img_profile.jpeg"; ?>"
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
                                    <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){ ?>
                                        <label class="form-control text-box">Not allowed</label>
                                    <?php } else {?>
                                    <input type="password" id="pass" name="edit_pass" class="form-control text-box" placeholder="password">
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
                                    <?php if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){ ?>
                                        <label class="form-control text-box">Not allowed</label>
                                    <?php } else {?>
                                    <input type="password" id="pass-confirm" name="edit_pass_confirm" class="form-control text-box" placeholder="confirm password">
                                    <?php } ?>
                                </div>
                                <div id="input-info-pass-confirm" class="d-none text-box d-flex gap-2 mt-1 py-1">
                                    <span class="material-symbols-outlined"></span>
                                    <span class=""></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label for="edit_img" class="form-label"><strong class="text-red">Url img</strong></label><br>
                            </span>
                            <div class="input-group d-flex text-center">
                                <input type="text" id="edit_img" name="edit_img" class="form-control text-box" placeholder="<?php echo $element["img_url"]; ?>">
                            </div>
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
                                    <input type="number" id="edit_role" name="edit_role" class="form-control text-box" placeholder="<?php echo $element["role"]; ?>">
                                <?php } else{ ?>
                                    <label class="form-control text-box"> <?php ($_SESSION["role"] == 1)? print "Admin": print "User"; ?> </label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div id="button_div" class="row mb-3 d-flex justify-content-center button">
                        <button type="button" name="other_info" onclick="last_page()" style="border: unset" class="navigate-left navigate btn btn-outline-light col-2 col-sm-2 col-md-1 d-flex justify-content-center"><span class="material-symbols-outlined">chevron_left</span></button>
                        <button type="submit" name="Button_id" value="<?php echo $element["id"]; ?>" class="btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center">Confirm</button>
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