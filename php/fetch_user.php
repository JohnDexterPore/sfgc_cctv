<?php
include 'db_conn.php';

$user_query = "SELECT * FROM tbl_user";
$user_result = sqlsrv_query($conn, $user_query);

if ($user_result) {
    $users = array();
    while ($row = sqlsrv_fetch_array($user_result, SQLSRV_FETCH_ASSOC)) {
        $users[] = $row;
    }
    sqlsrv_free_stmt($user_result);
} else {
    echo "Error: " . sqlsrv_errors();
}
