<!DOCTYPE html>
<html lang="it">

<head>
    <title>Home</title>
    <meta charset="UTF-8">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
</head>

<body class="vh-100">


<div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5">

    <?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

    <?php [$login_allowed, $user] = check_cookie(); ?>
    <?php if (check_user_auth($user)) {
        set_session($user); ?>

        <p>Welcome back, <?php echo $_SESSION["first_name"]; ?></p>
        <a href="logout.php" class="text-decoration-none">Logout</a>

        <!-- TODO: just for testing -->
        <?php session_destroy(); ?>

    <?php } else {
        $_SESSION["redirection"] = "/f1_project/views/private/private.php";
        error("401", "not_authorized", "private.php", "../public/login_form.php", "Unauthorized access.");
        exit;
    } ?>
</div>

</body>
</html>