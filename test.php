<?php
require_once ("DB/DB.php");
$conn = DB::connect();
$io = "cocco";
$tu = "pino";

$query = DB::get_record_by_field($conn, null, null, [$io, $tu] );
