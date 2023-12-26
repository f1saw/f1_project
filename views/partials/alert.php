<?php
function err_msg_alert($function = null) : void{
    if (isset($_SESSION["err"]) && $_SESSION["err"]) { ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mt-4 col-12" role="alert">
            <span class="material-symbols-outlined text-danger">warning</span>
            <strong class="text-danger">ERROR!</strong>&nbsp; <?php echo $_SESSION["err_msg"]; ?>
            <button onclick="<?php echo $function?>" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php
        unset($_SESSION["err"]);
        unset($_SESSION["err_msg"]);
    }
}

function succ_msg_alert($function = null) : void{
    if (isset($_SESSION["success"]) && $_SESSION["success"]) { ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mt-4 col-12" role="alert">
        <span class="material-symbols-outlined text-success">done</span>
        <strong class="text-success">Success!</strong>&nbsp;&nbsp;<?php echo $_SESSION["success_msg"]; ?>
        <button onclick="<?php echo $function?>" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
        unset($_SESSION["success"]);
        unset($_SESSION["success_msg"]);
    }
}