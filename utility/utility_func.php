<?php
//check_user_role() return true if user is admin, false otherwise
function check_user_role($conn, $params, $source = "N/A", $redirect_error = "") : bool{

    $role = DB::get_record_by_field($conn,
        "SELECT role FROM Users WHERE id = ?",
        ["i"],
        $params,
        $source,
        $redirect_error)[0];

    if (!$conn->close()) {
        error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/dashboard.php");
        exit;
    }

    if($role["role"] == 1){
        return true;
    }
    return false;
}
