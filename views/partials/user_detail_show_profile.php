<div class="container-fluid">
    <?php include("../partials/navbar.php"); ?>
    <main class="container-fluid nav-profile s">
        <div id="bg-profile" class="container d-flex justify-content-center">
            <div id="profile-data" class="container-element">
                <div class="d-flex justify-content-center">
                    <img id="photo_profile" class="rounded-circle" src="<?php if($element["img_url"] != null) echo $element['img_url']; else echo "/f1_project/images/default_img_profile.jpeg"; ?>"
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
                                <label class="form-control text-box" ><?php ($element["first_name"] != "")?print $element["first_name"]: print "No element";?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label class="form-label"><strong class="text-red">Lastname</strong></label><br>
                            </span>
                            <div class="input-group d-flex text-center">
                                <label class="form-control text-box" ><?php ($element["last_name"] != "")?print $element["last_name"]: print "No element"; ?></label>
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
                        <div class="col-12">
                            <span class="d-flex justify-content-center">
                                <label class="form-label"><strong class="text-red">Date of birth</strong></label><br>
                            </span>
                            <div class="input-group d-flex text-center">
                                <label class="form-control text-box" ><?php ($element["date_of_birth"] != "")?print $element["date_of_birth"]: print "No element"; ?></label>
                            </div>
                        </div>
                    </div>
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
                </div>
                <br>
                <div class="row mb-3 d-flex justify-content-center">
                    <button onclick="my_function()" type="button" class="btn btn-danger col-6 col-sm-6 col-md-5 d-flex align-items-center justify-content-center gap-2">Edit profile</button>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function my_function(){
        window.open("/f1_project/views/private/user_detail.php/?edit=1&id=<?php echo $element["id"]; ?>","_self");
    }
</script>