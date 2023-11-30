<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | User</title>
    <meta charset="UTF-8">

    <?php include("../partials/head.php"); ?>
    <?php require_once("../../auth/auth.php"); ?>
    <?php require_once("../../error_handling.php"); ?>
    <?php require_once ("../../DB/DB.php"); ?>
</head>

<body class="vh-100">

    <?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

    <?php [$login_allowed, $user] = check_cookie(); ?>
    <?php if (check_user_auth($user)) {
        set_session($user); ?>



    NAVBAR

    <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-5">




        <p>Welcome back, <?php echo $_SESSION["first_name"] . " (id: " . $_SESSION["id"] . ")"; ?> | <a href="logout.php" class="text-decoration-none">Logout</a></p>


        <div class="col-12 col-md-9">
            <h1 class="col-12 h1">ALL USERS</h1>
            <hr>

            <?php
            $conn = DB::connect();
            [$num_users, $users] = DB::stmt_get_record_by_field($conn,
            "SELECT * FROM Users;",
            "dashboard.php",
            "dashboard.php");
            if (!$conn->close()) {
                error("500", "conn_close()", "dashboard.php", "dashboard.php");
                exit;
            }
            ?>

            <?php if ($num_users > 0) { ?>

                    <!-- TODO: https://stackoverflow.com/questions/30981765/how-to-divide-table-to-show-in-pages-the-table-data-is-filled-dynamically-with -->

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
                            foreach ($users as $user) {
                                echo "<tr>" .
                                    "<th scope='row' class='text-center'>" .
                                    "<a href='user_detail.php/?id=" . $user["id"] ."' class='text-decoration-none'>" .
                                    $user["id"] .
                                    "</a>" .
                                    "</th>" .
                                    "<td class='text-center'>" . $user["first_name"] . "</td>" .
                                    "<td class='text-center'>" . $user["last_name"] . "</td>" .
                                    "<td class='text-center'>" . $user["email"] . "</td>" .
                                    "<td class='text-center'>" . $user["date_of_birth"] . "</td>" .
                                    "<td class='text-center'>" . $user["role"] . "</td>" .
                                    "<td class='text-center'>" . $user["newsletter"] . "</td>" .
                                    "<td class='text-center'>" . (($user["img_url"] != '')? $user["img_url"]: "<span class='material-symbols-outlined'>close</span>") . "</td>" .
                                    "<td class='text-center'>" .
                                    "<a href='user_delete.php/?id=" . $user["id"] ."' class='my-auto text-danger d-flex align-items-center justify-content-center text-decoration-none'>" .
                                    "<span class='material-icons'>delete</span></td>" .
                                    "</a>" .
                                    "</tr>";
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





        <!-- TODO: just for testing -->
        <?php session_destroy(); ?>
    </div>
    <?php } else {
        error("401", "not_authorized", "private.php", "../public/login_form.php", "Unauthorized access.");
        exit;
    } ?>

</body>
</html>