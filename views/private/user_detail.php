<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>
    <meta charset="UTF-8">
    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
</head>

<body>
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>
<?php [$login_allowed, $user] = check_cookie(); ?>
<?php if (check_admin_auth($user)) {
    set_session($user);

    $conn = DB::connect();
    $element = DB::get_record_by_field($conn,
        "SELECT first_name,last_name,email,img_url FROM Users WHERE id=?",
        ["i"], [$_GET["id"]], "user_detail.php", "user_detail.php");
    if (!$conn->close()) {
        error("500", "conn_close()", "user_detail.php", "dashboard.php");
        exit;
    }
    if($element != null) {
    ?>
        <main class="container-fluid vh-100 w-100 d-flex flex-column justify-content-center align-items-center">
            <div style="width: 40%;">
                <table class="table">
                    <thead class="table-info">
                    <tr>
                        <th style="width: 30%; position: relative" scope="col">#</th>
                        <th style="width: 40%; position: relative" scope="col">Information</th>
                        <th scope="col">
                            <img class="rounded-circle" style="width: 30px; height: 30px;" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "../../images/default_img_profile.jpeg"; ?>"
                                 alt="profile picture">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Firstname</th>
                        <td> <?php echo $element['first_name']; ?> </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Lastname</th>
                        <td> <?php echo $element['last_name']; ?> </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">email</th>
                        <td> <?php echo $element['email']; ?> </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <div class="container-fluid d-flex justify-content-end">
                    <a href="../../index.php"> <button style="position: relative; right: 20px" type="button" class="btn btn-primary">Home</button></a>
                    <a href="../../index.php"> <button type="button" class="btn btn-primary">Change photo</button></a>
                </div>
            </div>
        </main>
<?php
    }
    else
        echo "no information";
}
else{
    error("401", "not_authorized", "private.php", "../public/login_form.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>
