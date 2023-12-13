<!DOCTYPE html>
<html lang="en" >
<head>
    <title>Admin | Store</title>
    <meta charset="UTF-8">

    <?php
    if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
        error("500", "set_include_path()");
    ?>
    <?php include("views/partials/head.php"); ?>
    <?php require_once("auth/auth.php"); ?>
    <?php require_once("utility/error_handling.php"); ?>
    <?php require_once ("utility/store.php") ?>
    <?php require_once ("DB/DB.php"); ?>
    <?php require_once("views/partials/alert.php") ?>

    <link rel="stylesheet" href="/f1_project/assets/css/style.css">
    <link rel="stylesheet" href="/f1_project/assets/css/table_style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script> $(document).ready( function () { $('#table').DataTable(); }); </script>
</head>

<body class="vh-100 dark">

<?php if(session_status() == PHP_SESSION_NONE) session_start(); ?>

<?php [$login_allowed, $user] = check_cookie(); ?>
<?php if (check_admin_auth($user)) {
set_session($user); ?>

<div class="container-fluid">
    <?php include("views/partials/navbar.php") ?>

    <div class="flex-container d-flex flex-column justify-content-center align-items-center mt-5">

        <div class="container-element col-12 col-md-9">

            <?php

            $conn = DB::connect();
            [$num_products, $products] = DB::stmt_get_record_by_field($conn,
                "SELECT Products.id AS 'Products.id', Products.title AS 'Products.title', Products.price AS 'Products.price', Products.img_url AS 'Products.img_url', Teams.name AS 'Teams.name' FROM Products JOIN Teams ON Products.team_id = Teams.id;",
                "store/all.php",
                "/f1_project/views/private/dashboard.php");
            if (!$conn->close()) {
                error("500", "conn_close()", "store/all.php", "/f1_project/views/private/dashboard.php");
                exit;
            }

            ?>

            <?php if ($num_products > 0) { ?>

                <?php succ_msg_alert(); ?>
                <?php err_msg_alert(); ?>

                <table id="table" class="display">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">TITLE</th>
                            <th class="text-center">TEAM</th>
                            <th class="text-center">PRICE</th>
                            <th class="text-center fit-content col-2">IMGs</th>
                            <th class="text-center col-1">REMOVE</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $correspondence_vector = ["Products.title", "Teams.name"];
                    foreach ($products as $product) { ?>
                        <tr>
                            <th class='text-center'>
                                <a href='product_detail.php/?id=<?php echo $product["Products.id"] ?>' class="text-decoration-none" style="color: #4a82fc">
                                    <?php echo $product["Products.id"]; ?>
                                </a>
                            </th>

                            <?php for($i = 0;$i < count($correspondence_vector); $i++){?>
                                <td class='text-center'>
                                    <?php echo $product[$correspondence_vector[$i]]; ?>
                                </td>
                            <?php } ?>

                            <td class="text-center">
                                <?php [$int, $dec] = str2int_dec($product["Products.price"]); ?>
                                € <?php echo $int . "." . $dec ?>
                            </td>



                            <td class='text-center' >
                                <?php
                                if ($product["Products.img_url"]) {
                                    $img = explode("\t", $product["Products.img_url"]);
                                    if($img && $img[0] != '') { ?>
                                        <img style="width: 60px; height: 40px; object-fit: contain;" src="<?php echo $img[0]; ?>" alt="Profile pictures.">
                                    <?php }
                                    if($img && $img[1] != '') { ?>
                                        <img style="width: 60px; height: 40px; object-fit: contain;" src="<?php echo $img[1]; ?>" alt="Profile pictures.">
                                    <?php
                                    }
                                } else { ?>
                                    <span class='material-symbols-outlined'>close</span>
                                <?php }
                                ?>
                            </td>

                            <td class='text-center'>
                                <a href='delete.php/?id=<?php echo $product["Products.id"] ?>' class='my-auto d-flex align-items-center justify-content-center text-decoration-none'>
                                    <span class='material-icons text-danger'>delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php
                    } ?>
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
        $_SESSION['redirection'] = "/f1_project/views/private/table_users.php";
        error("401", "not_authorized", "table_users.php", "/f1_project/views/public/login_form.php", "Unauthorized access.");
        exit;
    } ?>
</div>
</body>
</html>