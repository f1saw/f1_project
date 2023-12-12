<?php

require_once("../DB.php");

$conn = DB::connect();
for ($i=0; $i<100; $i++){
    $caratteri = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $a = '';
    $b = '';
    for ($j = 0; $j < 5; $j++) {
        $a = $caratteri[rand(0, strlen($caratteri) - 1)];
        $b = $caratteri[rand(0, strlen($caratteri) - 1)];
        $f = $caratteri[rand(0, strlen($caratteri) - 1)];
    }
    $c = $a.$b.$f.'@gmail.com';
    $verify = DB::get_record_by_field($conn,
    "SELECT email FROM Users WHERE email=?",
    ["s"],
    [$c]);

    if($verify == null) {
        $hash_password = password_hash("a", PASSWORD_DEFAULT);
        DB::p_stmt_no_select($conn,
            "INSERT into users values (NULL, ?, ?, ?, ?, 0, null, null, null, null);",
            ["s", "s", "s", "s"],
            [$a, $b, $c, $hash_password]);
    }
}
if (!$conn->close()) {
    error("500", "conn_close()");
    exit;
}
echo "num users: ".$i;