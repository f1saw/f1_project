<!DOCTYPE html>
<html lang="en">
<head>
    <title>User detail</title>
    <meta charset="UTF-8">
    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>

</head>

<body>
<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php
[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    if(!isset($_GET["id"]) && $_GET["id"] == null) {
        error("401", " Unauthorized access.", "user_detail.php", "/f1_project/views/private/table_users.php", "No user select.");
        exit;
    }

    $conn = DB::connect();
    $element = DB::get_record_by_field($conn,
        "SELECT first_name, last_name, img_url, role FROM Users WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "user_detail.php",
        "/f1_project/views/private/user_detail.php")[0];
    if (!$conn->close()) {
        error("500", "conn_close()", "user_detail.php", "/f1_project/views/private/table_users.php");
        exit;
    }
    if($element != null) {
    ?>

        <main class="container-fluid vh-100 w-100 d-flex flex-column justify-content-center align-items-center">
            <img class="rounded-circle" style="width: 70px; height: 70px;" src="<?php if($element['img_url'] != null) echo $element['img_url']; else echo "/f1_project/images/default_img_profile.jpeg"; ?>"
                 alt="profile picture">
            <div style="width: 40%;">
                <form method="post" id="edit_form" action="/f1_project/views/private/edit_user.php">
                    <table class="table">
                        <thead class="table-info">
                        <tr>
                            <th style="width: 30%; position: relative" scope="col">#</th>
                            <th style="width: 1%; position: relative" scope="col">Information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Firstname</th>
                            <!--if(non premo bottone edit) then mostra nome else mostra input-->
                             <td> <?php echo $element['first_name']; ?> </td>

                            <td>
                                <label for="edit_firstname"></label>
                                <input type="text" name="edit_firstname" id="edit_firstname" placeholder="<?php echo $element['first_name'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Lastname</th>

                             <td> <?php echo $element['last_name']; ?> </td>
                            <td>
                                <label for="edit_lastname"></label>
                                <input type="text" name="edit_lastname" id="edit_lastname" placeholder="<?php echo $element['last_name'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Image</th>
                            <td> <?php echo $element['img_url']; ?> </td>

                            <td>
                                <label for="edit_img"></label>
                                <input type="text" name="edit_img" id="edit_img" placeholder="<?php echo $element['img_url'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Role</th>
                            <td> <?php echo $element['role']; ?> </td>
                            <td>
                                <label for="edit_role"></label>
                                <input type="text" name="edit_role" id="edit_role" placeholder="<?php echo $element['role'] ?>">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="container-fluid d-flex justify-content-end">
                        <a href="/f1_project/views/private/dashboard.php"> <button style="position: relative; right: 20px" type="button" class="btn btn-primary">Home</button></a>
                        <button type="submit" name="Button" class="btn btn-light" value="<?php echo $_GET["id"] ?>">Confirm</button>
                    </div>
                </form>
            </div>
        </main>
        -->
<?php
    }
    else
        // tmp
        echo "no information";
}
else{
    error("401", "not_authorized", "user_detail.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
    exit;
}
?>
</body>
</html>
