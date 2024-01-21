<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");
if(session_status() == PHP_SESSION_NONE) session_start();

require_once("controllers/auth/auth.php");
require_once("utility/error_handling.php");
require_once("DB/DB.php");
require_once("utility/utility_func.php");
require_once("utility/msg_error.php");
require_once ("utility/aws.php");

const SOURCE = "\controllers\users\\update_profile.php";
define("REDIRECT", "/f1_project/show_profile.php" . (($_POST["id_to_update"] != null) ? ("?id=" . $_POST["id_to_update"]) : ""));

const MAX_NUMBER_FILES = 1;
const INPUT_NAMES = ["firstname", "lastname", "email", "edit_date_of_birth", "pass", "edit_news", "edit_img", "edit_role"];


[$login_allowed, $user] = check_cookie();
if (!check_user_auth($user)) {
    $_SESSION['redirection'] = "/f1_project/update_profile.php?id={${${$_POST['id_to_update']??''}}}";
    error("401", "not_authorized", "\controllers\users\\update_profile.php", "/f1_project/views/public/auth/login.php", "Unauthorized access.");
    exit;
}
set_session($user);



/* ERROR | Fields NOT set */
if (!isset($_POST["firstname"]) || !isset($_POST["lastname"]) || !isset($_POST["email"])) {
    error("-1", "Input fields NOT provided", SOURCE, REDIRECT);
    exit;
}

/* ERROR | Empty input fields */
if (preg_match("/\s+/", $_POST["firstname"])
    || preg_match("/\s+/", $_POST["lastname"])
    || preg_match("/\s+/", $_POST["email"])) {
    error("-1", "Input fields are EMPTY", SOURCE, REDIRECT);
    exit;
}
/*if (!isset($_POST["id_to_update"]) || preg_match("/\s+/", $_POST["id_to_update"])) {
    $_POST["id_to_update"] = $_SESSION["id"];
}*/

/* Cleaning input */
$id_to_update = (isset($_POST["id_to_update"]) && !preg_match("/\s+/", $_POST["id_to_update"]))? $_POST["id_to_update"]:$_SESSION["id"];
$firstname = preg_replace("/\s+/", "", $_POST["firstname"]);
$lastname = preg_replace("/\s+/", "", $_POST["lastname"]);
$email = preg_replace("/\s+/", "", $_POST["email"]);
$date_of_birth = preg_replace("/\s+/", "", $_POST["edit_date_of_birth"]??"");
$password = trim(preg_replace("/\s+/", "", $_POST["pass"]??""));
$password_confirm = trim(preg_replace("/\s+/", "", $_POST["pass_confirm"]??""));
$img_url = preg_replace("/\s+/", "", $_POST["edit_img"]??"");
$newsletter = $_POST["edit_news"]??0;
$role = $_POST["edit_role"]??-1; // -1 means that role input has not been updated

/* Regex Email */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    error("-1", "EMAIL pattern NOT valid.", SOURCE, REDIRECT);
    exit;
}

// REGEX DATE OF BIRTH dd/mm/yyyy
if ($date_of_birth != "" &&!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date_of_birth)) {
    error("-1", "Date of birth pattern NOT valid.", SOURCE, REDIRECT);
    exit;
}

// Role
if ($role != -1 && $role != 0 && $role != 1) {
    error("-1", "Role pattern NOT valid. Please provide a number between 0 and 1.", SOURCE, REDIRECT);
    exit;
}

// Newsletter
if ($newsletter != 0 && $newsletter != 1) {
    error("-1", "Newsletter pattern NOT valid. Please provide a number between 0 and 1.", SOURCE, REDIRECT);
    exit;
}

/* ERROR | passwords (mis)matching */
if ($password != $password_confirm) {
    error("-1", "Mismatched passwords.", SOURCE, REDIRECT);
    exit;
}

/* Password handling */
$password_change = 0;
$hash_password = "";
if ($password != "") {
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $password_change = 1;
}

/* Role constraint */
$previous_image = "";
if ($role > -1) {
    // Role field has been updated, so I need to check if role constraint failed
    $conn = DB::connect(SOURCE, REDIRECT);
    $row = DB::get_record_by_field($conn,
        "SELECT role, img_url FROM Users WHERE id = ?;",
        ["i"],
        [$id_to_update],
        SOURCE,
        REDIRECT)[0];
    if (!$conn->close()) {
        error("-1", "conn->close", SOURCE, REDIRECT);
        exit;
    }
    $previous_role = $row["role"];
    $previous_image = ($row["img_url"] != "")? $row["img_url"]:-1;

    if ($previous_role == 1 && $role != 1) {
        error("-1", "You cannot modify the role of an Administrator.", SOURCE, REDIRECT);
        exit;
    }
}


/* IMAGE HANDLING */
// No image urls provided, so "images-local" should be taken into account
if ($img_url == "" && isset($_FILES["image-local"]) && $_FILES["image-local"]["name"]) {

    // Make sure to look for empty file names and paths, the array might contain empty strings. Use array_filter() before count.
    //$files = array_filter($_FILES['image-local']['name']);
    // var_dump($_FILES["image-local"]);
    if (gettype($_FILES["image-local"]["name"]) !== "string") {
        // It is an array, so multiple files have been uploaded.
        // This is NOT allowed
        // TODO: redirect to users/all.php o su show_profile.php
        error("-1", "Max number of files exceeded.", SOURCE, REDIRECT);
        exit;
    }

    $s3_file_link = "";

    $file_temp_src = $_FILES["image-local"]["tmp_name"];
    $filename = $_FILES["image-local"]["name"];

    [$status, $statusMsg, $s3_file_link] = aws_s3_upload($filename, $file_temp_src);
    if ($status == "danger") {
        error("-1", "AWS S3: $statusMsg.", SOURCE, REDIRECT);
        exit;
    }
    $img_url = $s3_file_link;
}


// Look for the previous url image, if not done yet
if ($previous_image == "") {
    // Role field has been updated, so I need to check if role constraint failed
    $conn = DB::connect(SOURCE, REDIRECT);
    $row = DB::get_record_by_field($conn,
        "SELECT img_url FROM Users WHERE id = ?;",
        ["i"],
        [$id_to_update],
        SOURCE,
        REDIRECT)[0];
    if (!$conn->close()) {
        error("-1", "conn->close", SOURCE, REDIRECT);
        exit;
    }
    $previous_image = ($row["img_url"] != "")? $row["img_url"]:-1;
}

if ($previous_image != $img_url) {
    if (preg_match("#^http://f1-saw.s3.eu-central-1.amazonaws.com/*#", $previous_image)) {
        aws_delete_img($previous_image);
    }
}






// TODO: validate max length

$password_query = $password_change?"password = ?, ":"";
$role_query = ($role > -1)?"role = ?, ":"";
$query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, $password_query date_of_birth = ?, $role_query img_url = ?, newsletter = ?
         WHERE id = ?;";
$type_params = ["s", "s", "s"];
$params = [$firstname, $lastname, $email];
if ($password_change) {
    $type_params[] = "s";
    $params[] = $hash_password;
}
$type_params[] = "s";
$params[] = $date_of_birth;
if ($role > -1) {
    $type_params[] = "i";
    $params[] = $role;
}
$type_params[] = "s";
$params[] = $img_url;
$type_params[] = "i";
$params[] = $newsletter;
$type_params[] = "i";
$params[] = $id_to_update;

/* DB */
$conn = DB::connect(SOURCE, REDIRECT);
DB::p_stmt_no_select(
    $conn,
    $query,
    $type_params,
    $params,
    SOURCE, REDIRECT
);
if (!$conn->close()) {
    error("500", "conn_close()", SOURCE, REDIRECT);
    exit;
}

if (!isset($_SESSION["err"]) || $_SESSION["err"] === 0) {
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Update completed successfully.";
}

if(isset($_SESSION['redirection'])){
    header("Location: {$_SESSION['redirection']}");
    unset($_SESSION['redirection']);
    exit;
}

header("location: /f1_project/views/private/users/all.php");
exit;







/*
$e_firstname = 0;
$e_lastname = 1;
$e_email = 2;
$e_date_of_birth = 3;
$e_password = 4;
$e_news = 5;
$e_img = 6;
$e_role = 7;

$db_col_edit = ["first_name", "last_name", "email", "date_of_birth", "password",
    "newsletter", "img_url", "role"];

for ($j=0; $j<4; ++$j ){
    if (isset($_POST[INPUT_NAMES[$j]]))
        $_POST[INPUT_NAMES[$j]] = preg_replace('!\s+!', '', $_POST[INPUT_NAMES[$j]]);
}

if(isset($_POST[INPUT_NAMES[$e_password]]) && !isset($_POST["pass_confirm"])){
    msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Please confirm the password");
    exit;
}

if(isset($_POST[INPUT_NAMES[$e_password]]))
    $_POST[INPUT_NAMES[$e_password]] = trim($_POST[INPUT_NAMES[$e_password]]);

if(isset($_POST["pass_confirm"]) && $_POST["pass_confirm"] != "") {
    $_POST["pass_confirm"] = trim($_POST["pass_confirm"]);
    if ($_POST["pass_confirm"] == " ") {
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Empty input fields.");
        exit;
    }
}

for ($k=0; $k<5; ++$k ){
    if (isset($_POST[INPUT_NAMES[$k]]) && $_POST[INPUT_NAMES[$k]] != "") {
        if ($_POST[INPUT_NAMES[$k]] == " ") {
            msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Empty input fields.");
            exit;
        }
    }
}

if(isset($_POST[INPUT_NAMES[$e_email]]) && $_POST[INPUT_NAMES[$e_email]] != "") {
    if (!filter_var($_POST[INPUT_NAMES[$e_email]], FILTER_VALIDATE_EMAIL)) {
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"EMAIL pattern NOT valid.");
        exit;
    }
}

if(isset($_POST[INPUT_NAMES[$e_date_of_birth]]) && $_POST[INPUT_NAMES[$e_date_of_birth]] != "") {
    if ($_POST[INPUT_NAMES[$e_date_of_birth]] && !preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST[INPUT_NAMES[$e_date_of_birth]])) {
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Date of birth pattern NOT valid.");
        exit;
    }
}

if(isset($_POST[INPUT_NAMES[$e_password]]) && $_POST[INPUT_NAMES[$e_password]] != "") {
    if ($_POST[INPUT_NAMES[$e_password]] != $_POST["pass_confirm"]) {
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Mismatched passwords.");
        exit;
    }
    $_POST[INPUT_NAMES[$e_password]] = password_hash($_POST[INPUT_NAMES[$e_password]], PASSWORD_DEFAULT);
}

if (isset($_POST[INPUT_NAMES[$e_news]]) && $_POST[INPUT_NAMES[$e_news]] != ""){
    if(!is_numeric($_POST[INPUT_NAMES[$e_news]])){
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Newsletter: please enter a number.");
        exit;
    }

    if($_POST[INPUT_NAMES[$e_news]] != 0){
        $_POST[INPUT_NAMES[$e_news]] = 1;
    }
}

if(isset($_POST[INPUT_NAMES[$e_role]]) && $_POST[INPUT_NAMES[$e_role]] != ""){
    if(!is_numeric($_POST[INPUT_NAMES[$e_role]])){
        msg_error($_POST["id_to_update"], $_SESSION["role"], $_SESSION["id"],"Role: please enter a number.");
        exit;
    }

    if($_POST[INPUT_NAMES[$e_role]] != 0){
        $_POST[INPUT_NAMES[$e_role]] = 1;
    }

    $conn = DB::connect("\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
    $check_role = check_user_role($conn,
        [$_POST["id_to_update"]],
        "\controllers\users\\update_profile.php",
        "/f1_project/views/private/dashboard.php");

    if ($check_role){
        msg_err_edit_user_admin("You cannot change the administrator role.");
        exit;
    }
}
*/

// NOT required. dbms will do it
/*if(isset($_POST[INPUT_NAMES[$e_email]])){
    $conn = DB::connect("\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
    $check = DB::get_record_by_field(
        $conn,
        "SELECT email FROM users WHERE email = ?",
        ["s"],
        [$_POST[INPUT_NAMES[$e_email]]],
        "\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
    if($check != null){
        $_POST[INPUT_NAMES[$e_email]] = "";
        $_SESSION["err"] = 1;
        $_SESSION["err_msg"] = "Email already in use";
    }
    if (!$conn->close()) {
        error("500", "conn_close()", "\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
        exit;
    }
}*/



/*
if (!isset($_POST["id_to_update"])) {
    $_POST["id_to_update"] = $_SESSION["id"];
}
for($i=0; $i < 8; ++$i) {
    echo "b";
    if (isset($_POST[INPUT_NAMES[$i]]) && isset($_POST['id_to_update'])) {
        if($_POST[INPUT_NAMES[$i]] == "") {
            continue;
        }
        $change_value = $_POST[INPUT_NAMES[$i]];
        $conn = DB::connect("\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
        $change_value = $conn->real_escape_string($change_value); // do not do escape if prepared statement
        DB::p_stmt_no_select(
            $conn,
            "UPDATE users SET $db_col_edit[$i] = '$change_value' WHERE id = ?",
            ["i"],
            [$_POST['id_to_update']],
            "\controllers\users\\update_profile.php", "/f1_project/show_profile.php?id=" . $_POST["id_to_update"]
        );
        if (!$conn->close()) {
            error("500", "conn_close()", "\controllers\users\\update_profile.php", "/f1_project/views/private/users/all.php");
            exit;
        }
    }
} */

/*
if (!isset($_SESSION["err"]) || $_SESSION["err"] === 0) {
    $_SESSION["success"] = 1;
    $_SESSION["success_msg"] = "Update completed successfully.";
}
echo "d";
if(isset($_SESSION['redirection'])){
    //echo $_SESSION["redirection"];
    //exit;
    header("Location: {$_SESSION['redirection']}");
    unset($_SESSION['redirection']);
    exit;
}

echo "e";
header("location: /f1_project/views/private/users/all.php");
exit;
*/