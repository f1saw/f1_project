<div class="container-fluid">
    <?php include("../partials/navbar.php"); ?>
    <main>
        <div id="bg-profile" class="flex-container d-flex justify-content-center">
            <form id="profile-data" class="container-element" method="POST" action="/f1_project/views/private/edit_user.php/?my_profile=<?php (isset($_GET["my_profile"]) && $_GET["my_profile"] == 1)?print 1: print 0 ?>">
                <div class="d-flex justify-content-center">
                    <img id="photo_profile" class="rounded-circle" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/images/default_img_profile.jpeg"; ?>"
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
                                <input type="text" name="edit_firstname" class="form-control text-box" placeholder="<?php echo $element["first_name"]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label for="edit_lastname" class="form-label"><strong class="text-red">Lastname</strong></label><br>
                            </span>
                            <div class="input-group d-flex text-center">
                                <input type="text" name="edit_lastname" class="form-control text-box" placeholder="<?php echo $element["last_name"]; ?>">
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
                            <label class="form-control text-box"><?php ($element["email"] != "")?print $element["email"]: print "No element"; ?></label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <span class="d-flex justify-content-center">
                            <label for="edit_img" class="form-label"><strong class="text-red">Url img</strong></label><br>
                        </span>
                        <div class="input-group d-flex text-center">
                            <input type="text" name="edit_img" class="form-control text-box" placeholder="<?php echo $element["img_url"]; ?>">
                        </div>
                    </div>
                    <?php
                    if($_SESSION["role"] == 1 && $_SESSION["id"] != $element["id"]){?>
                        <div class="col 12 col-md-6">
                            <span class="d-flex justify-content-center">
                                <label for="edit_role" class="form-label"><strong class=" text-red">role</strong></label><br>
                            </span>
                            <div class="input-group d-flex text-center">
                                <input type="number" name="edit_role" class="form-control text-box" placeholder="<?php echo $element["role"]; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    else {?>
                        <div class="col-12 col-md-6">
                            <div class="col-12">
                                <span class="d-flex justify-content-center">
                                    <label class="form-label"><strong class="text-red">Remember me</strong></label><br>
                                </span>
                                <div class="input-group d-flex text-center">
                                    <label class="form-control text-box" ><?php ($element["cookie_id"] != null)? print "Active": print "inactive" ?></label>
                                </div>
                            </div>
                        </div>
                    <?php
                    }?>
                </div>
                <br>
                <div class="row mb-3 d-flex justify-content-center">
                    <button type="submit" name="Button_id" value="<?php echo $_GET["id"]; ?>" class="btn btn-danger col-12 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">Confirm</button>
                </div>
            </form>
        </div>
    </main>
</div>