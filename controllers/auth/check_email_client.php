<?php

require_once ("../../DB/DB.php");

if (isset($_GET["email"])) {
    $email = $_GET["email"];

    $conn = DB::connect();

    $res = DB::get_record_by_field($conn,
        "SELECT email FROM users WHERE email = ?",
               ["s"],
               [$email]);
    if ($res != null){
        echo json_encode((['exists' => true]));
    }
    else {
        echo json_encode(['exists_no_match' => true]);
    }
}
else{
    echo json_encode(['error' => 'The email parameter is mandatory.']);
}
