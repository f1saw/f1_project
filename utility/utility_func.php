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
        error("500", "conn_close()", "/f1_project/views/private/edit_user.php", "/f1_project/views/private/table_users.php");
        exit;
    }

    if($role["role"] == 1){
        return true;
    }
    return false;
}

// Questa funzione ha lo scopo di estrarre le informazioni dell'utente che si decide di visualizzare
// dalla dashboard. Se nessun utente è stato selezionato vengono ritornate le info dell'utente collegato
function choose_correct_data($id) : array{
    if($id == null) {
        $_SESSION['redirection'] = "/f1_project/views/private/user_detail.php";
        $current_id = $_SESSION["id"];
    }

    if(!isset($current_id)) {
        $conn = DB::connect();
        $element = DB::get_record_by_field($conn,
            "SELECT * FROM Users WHERE id = ?",
            ["i"],
            [$id],
            "user_detail.php",
            "/f1_project/views/private/user_detail.php")[0];
        if (!$conn->close()) {
            error("500", "conn_close()", "user_detail.php", "/f1_project/views/private/table_users.php");
            exit;
        }
    }
    else{
        $element = array_flip(array("first_name", "last_name", "email", "date_of_birth", "cookie_id", "img_url"));

        $element["id"]            = $_SESSION["id"];
        $element["first_name"]    = $_SESSION["first_name"];
        $element["last_name"]     = $_SESSION["last_name"];
        $element["email"]         = $_SESSION["email"];
        $element["date_of_birth"] = $_SESSION["date_of_birth"];
        $element["cookie_id"]     = $_SESSION["cookie_id"];
        $element["img_url"]       = $_SESSION["img_url"];
    }
    return $element;
}
