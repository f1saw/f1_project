<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

require_once("utility/error_handling.php");

$ini = parse_ini_file("config/keys.ini");

const PRODUCTS_DEFAULT_SIZE = "one";
const PRODUCTS_ARRAY = ["id", "title", "description", "price", "img_url", "team_id", "color", "size"];
const PRODUCTS_MAX_LENGTHS = [-1, 150, 500, -1, 700, -1, 20, 20];

class DB {

    public static function connect($source = "N/A", $redirect_error = ""): mysqli {
        global $ini;

        error_reporting(0);
        mysqli_report(MYSQLI_REPORT_OFF);

        $conn = new mysqli($ini["hostname"], $ini["username"], $ini["password"], $ini["database"], $ini["port"]);
        if ($conn->connect_errno) {
            error("500", "mysqli error: $conn->error", $source, $redirect_error);
            exit;
        }
        $conn->set_charset("utf8mb4");
        if ($conn->errno) {
            error("500", "mysqli error: $conn->error", $source, $redirect_error);
            exit;
        }

        return $conn;
    }

    public static function get_record_by_field($conn, $query, $type_params, $params, $source = "N/A", $redirect_error = "") {

        $stmt = self::p_stmt_bind_execute($conn, $query, $type_params, $params, $source, $redirect_error);

        if (!$res = $stmt->get_result()) {
            error("500", "get_result(): $stmt->error", $source, $redirect_error);
            exit;
        }
        if (!$stmt->close()) {
            error("500", "stmt_close error: $stmt->error", $source, $redirect_error);
            exit;
        }
        if (($element = $res->fetch_all(MYSQLI_ASSOC)) === false) {
            error("500", "fetch_assoc()", $source, $redirect_error);
            exit;
        }
        $res->free_result();

        return $element;
    }

    public static function stmt_no_select($conn, $query, $source = "N/A", $redirect_error = ""): void {
        if (!$conn->query($query)) {
            error("500", "mysqli: $conn->error", $source, $redirect_error);
            exit;
        }
    }

    public static function stmt_get_record_by_field($conn, $query, $source = "NA", $redirect_error = "") {
        if (!($res = $conn->query($query))) {
            error("500", "mysqli: $conn->error", $source, $redirect_error);
            exit;
        }
        return [$res->num_rows, $res->fetch_all(MYSQLI_ASSOC)];
    }

    public static function p_stmt_no_select($conn, $query, $type_params, $params, $source = "N/A", $redirect_error = "", $order_delete_id = null): void {
        $stmt = self::p_stmt_bind_execute($conn, $query, $type_params, $params, $source, $redirect_error, $order_delete_id);

        if (!$stmt->close()) {
            error("500", "stmt_close error: $stmt->error", $source, $redirect_error);
            exit;
        }
    }

    public static function p_stmt_bind_execute($conn, $query, $type_params, $params, $source = "", $redirect_error  = "", $order_delete_id = null) {
        $s_type_params = implode("", $type_params);

        if (!$stmt = $conn->prepare($query)) {
            error("500", "mysqli prepare: $conn->error", $source, $redirect_error);
            exit;
        }
        if (!$stmt->bind_param($s_type_params, ...$params)) {
            error("500", "mysqli bind_param: $conn->error", $source, $redirect_error);
            exit;
        }
        if (!$stmt->execute()) {
            if ($order_delete_id)
                DB::stmt_no_select($conn, "DELETE FROM orders WHERE id = '$order_delete_id';", "DB.php", "/f1_project/views/public/store/cart.php");
            error("500", "stmt_execute error: $stmt->error", $source, $redirect_error, $order_delete_id?"Something went wrong! Maybe one of your products is not available anymore.":null);
            exit;
        }
        return $stmt;
    }
}