<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | User</title>
    <meta charset="UTF-8">
    <!--modificare la navbar-->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/index_style.css">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../utility/error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
    <?php require_once("../partials/alert.php") ?>

</head>

<body class="vh-100 bg-dark">

    <?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

    <?php [$login_allowed, $user] = check_cookie(); ?>
    <?php if (check_admin_auth($user)) {
        set_session($user); ?>

    <?php include("../partials/navbar.php") ?>

    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5">

        <div class="col-12 col-md-9">
            <h1 class="col-12 h1">ALL USERS</h1>
            <hr>

            <?php
            $conn = DB::connect();
            [$num_users, $users] = DB::stmt_get_record_by_field($conn,
            "SELECT * FROM Users;",
            "table_users.php",
            "table_users.php");
            if (!$conn->close()) {
                error("500", "conn_close()", "table_users.php", "/f1_project/views/private/table_users.php");
                exit;
            }
            ?>

            <?php if ($num_users > 0) { ?>

                    <!-- TODO: https://stackoverflow.com/questions/30981765/how-to-divide-table-to-show-in-pages-the-table-data-is-filled-dynamically-with -->
                <?php succ_msg_alert(); ?>
                <?php err_msg_alert(); ?>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">FIRST NAME</th>
                        <th scope="col" class="text-center">LAST NAME</th>
                        <th scope="col" class="text-center">E-MAIL</th>
                        <th scope="col" class="text-center fit-content col-2">DATE OF BIRTH</th>
                        <th scope="col" class="text-center col-1">ROLE</th>
                        <th scope="col" class="text-center col-1">NEWSLETTER</th>
                        <th scope="col" class="text-center col-1">IMG</th>
                        <th scope="col" class="text-center col-1">REMOVE</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $correspondence_vector = ["first_name", "last_name",
                                "email", "date_of_birth", "role", "newsletter"];
                            foreach ($users as $user) { ?>
                                <tr>
                                    <th scope='row' class='text-center'>
                                        <a href='user_detail.php/?id= <?php echo $user["id"] ?>' class="text-decoration-none">
                                            <?php echo $user["id"]; ?>
                                        </a>
                                    </th>
                                    <?php for($i = 0;$i < 6; ++$i){?>
                                    <td class='text-center' <?php if($user["img_url"] != '') echo 'style="position: relative; top: 10px"'; ?>>
                                        <?php echo $user[$correspondence_vector[$i]]; ?>
                                    </td>
                                    <?php } ?>
                                    <td class='text-center'>
                                        <?php
                                        if($user["img_url"] != ''){ ?>
                                            <img style="width: 70px; height: 50px; object-fit: cover;" src="<?php echo $user['img_url']; ?>" alt="Profile pictures.">
                                        <?php
                                        }
                                        else{ ?>
                                        <span class='material-symbols-outlined'>close</span>
                                        <?php
                                        } ?>
                                    </td>
                                    <td class='text-center'>
                                        <a href='user_delete.php/?id= <?php echo $user["id"] ?>' class='my-auto text-danger d-flex align-items-center justify-content-center text-decoration-none'>
                                            <span class='material-icons'>delete</span>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }

                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="alert border-dark text-dark fade show d-flex align-items-center justify-content-center mt-4 col-12" role="alert">
                    <span class="material-symbols-outlined">description</span>
                    <span class="mx-2">
                    <b>INFO</b>&nbsp;| No Data available!
                </span>
                </div>
            <?php } ?>
        </div>


        <a href="/f1_project/views/private/store/product_new_form.php">
            New product
        </a>

        <!-- TODO: just for testing -->
        <?php session_destroy(); ?>
    </div>
    <?php } else {
        error("401", "not_authorized", "table_users.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
        exit;
    } ?>

</body>
</html>