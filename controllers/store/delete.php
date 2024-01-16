<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");
require_once ("utility/aws.php");

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

[$login_allowed, $user] = check_cookie();
if (check_admin_auth($user)) {
    set_session($user);

    $conn = DB::connect("\controllers\store\delete.php", "/f1_project/views/private/store/all.php");

    // Delete AWS S3 images (if needed)
    $imgs_str = DB::get_record_by_field($conn,
    "SELECT img_url FROM Products WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "\controllers\store\delete.php",
        "/f1_project/views/private/store/all.php")[0]["img_url"];
    $imgs = explode("\t", $imgs_str);
    foreach ($imgs as $img) {
        if (preg_match("#^http://f1-saw.s3.eu-central-1.amazonaws.com/*#", $img)) {
            $img = explode("http://f1-saw.s3.eu-central-1.amazonaws.com/", $img)[1];
            // I have to delete image from S3 bucket
            [$region, $version, $access_key_id, $secret_access_key, $bucket] = config_aws_s3();
            $s3 = new S3Client([
                "version" => $version,
                "region" => $region,
                "credentials" => [
                    "key" => $access_key_id,
                    "secret" => $secret_access_key
                ],
                // TODO: scheme to change in 'https' when deploy to live server if it uses https
                'scheme' => 'http'
            ]);

            try {
                $result = $s3->deleteObject([
                    'Bucket' => $bucket,
                    'Key' => $img
                ]);
            }
            catch (S3Exception $e) {
                exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
            }
        }
    }



    DB::p_stmt_no_select($conn,
        "DELETE FROM Products WHERE id = ?",
        ["i"],
        [$_GET["id"]],
        "\controllers\store\delete.php",
        "/f1_project/views/private/store/all.php");

    if (!$conn->close()) {
        error("500", "conn_close()", "\controllers\store\delete.php", "/f1_project/views/private/store/all.php");
        exit;
    }
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Product deleted.";
    header("location:  /f1_project/views/private/store/all.php");
}
else {
    $_SESSION['redirection'] = "/f1_project/controllers/store/delete.php?id=${${$_GET['id']??''}}";
    error("401", "not_authorized", "\controllers\store\delete.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
}
exit;