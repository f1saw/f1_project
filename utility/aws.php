<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require 'vendor/autoload.php';
use Aws\S3\S3Client;

const PREFIX_LENGTH = 5;

$ini = parse_ini_file("config/keys.ini");

function config_aws_s3(): array {
    global $ini;
    return [$ini["aws_region"], $ini["aws_version"], $ini["aws_access_key"], $ini["aws_secret_key"], $ini["aws_bucket"]];
}

/**
 * Function used to upload a specific image on AWS S3 (configuration params are already provided inside the function)
 * @param $filename
 * @param $file_temp_src
 * @return array
 */
function aws_s3_upload($filename, $file_temp_src): array {

    // Make each filename unique in the bucket
    $filename = date('dmYHis').str_replace(" ", "", basename($filename));

    $status = "danger";
    $statusMsg = "";
    $s3_file_link = "";

    [$region, $version, $access_key_id, $secret_access_key, $bucket] = config_aws_s3();

    // Allow certain file formats
    $filename = basename($filename);
    $file_type = pathinfo($filename, PATHINFO_EXTENSION);
    $allow_types = array('jpg', 'png', 'jpeg');
    if (in_array($file_type, $allow_types)) {

        // File temp source
        if (is_uploaded_file($file_temp_src)) {

            // Instantiate an AWS S3 client
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
                $result = $s3->putObject([
                    "Bucket" => $bucket,
                    "Key" => $filename,
                    "ACL" => "public-read",
                    "SourceFile" => $file_temp_src
                ]);
                $result_arr = $result->toArray();

                if (!empty($result_arr["ObjectURL"])) {
                    $s3_file_link = $result_arr["ObjectURL"];
                } else {
                    $api_error = "Upload Failed! S3 Object URL NOT found!";
                }
            } catch (AWS\S3\Exception\S3Exception $e) {
                $api_error = $e->getMessage();
            } catch (Exception $e) {
                $statusMsg = $e;
            }

            if (empty($api_error)) {
                $status = "success";
                $statusMsg = "File was uploaded to the S3 bucket successfully!";
            } else {
                $statusMsg = $api_error;
            }
        } else {
            $statusMsg = "File upload failed!";
        }
    } else {
        $statusMsg = "Sorry, only Image files are allowed to upload.";
    }

    return [$status, $statusMsg, $s3_file_link];
}