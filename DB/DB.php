<?php

require_once ("../utils/error_handling.php");
$ini = parse_ini_file("../config/keys.ini");

class DB {

    public static function connect($source = "N/A", $redirect_error = "index.php"): mysqli {
        global $ini;

        error_reporting(0);
        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = new mysqli($ini["hostname"], $ini["username"], $ini["password"], $ini["database"], $ini["port"]);
        if ($conn->connect_errno)
            error("500", "mysqli error: $conn->connect_errno", $source, $redirect_error);
        $conn->set_charset("utf8mb4");
        if ($conn->errno)
            error("500", "mysqli error: $conn->error", $source, $redirect_error);

        return $conn;
    }

    public static function get_record_by_field($conn, $query, $type_params, $params) {

        $stmt = self::p_stmt_bind_execute($conn, $query, $type_params, $params);

        if (!$res = $stmt->get_result())
            error("500", "get_result()");
        if (!$stmt->close())
            error("500", "stmt_close error: $stmt->error");
        if (($element = $res->fetch_assoc()) === false)
            error("500", "fetch_assoc()");
        $res->free_result();

        return $element;
    }


    public static function p_stmt_no_select($conn, $query, $type_params, $params): void {
        $stmt = self::p_stmt_bind_execute($conn, $query, $type_params, $params);
        if (!$stmt->close())
            error("500", "stmt_close error: $stmt->error");
    }

    public static function p_stmt_bind_execute($conn, $query, $type_params, $params) {
        $s_type_params = implode("", $type_params);

        if (!$stmt = $conn->prepare($query))
            error("500", "mysqli errror: $conn->error");
        if (!$stmt->bind_param($s_type_params, ...$params))
            error("500", "mysqli errror: $conn->error");
        if (!$stmt->execute())
            error("500", "stmt_execute error: $stmt->error");
        return $stmt;
    }
}