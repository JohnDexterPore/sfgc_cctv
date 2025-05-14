<?php
include 'db_conn.php';

$currentDate = date('Y-m-d');
$condition = "WHERE CAST(record_input_date AS DATE) = '$currentDate'";

if (isset($_POST["search_button"])) {
    $search_date = '';
    $search_branch = '';
    $search_area = '';

    if (isset($_POST["search_date"]) && !empty($_POST["search_date"])) {
        $search_date = "CAST(record_input_date AS DATE) = '" . $_POST["search_date"] . "'";
    } else {
        $search_date = '';
    }
    if (isset($_POST["search_branch"]) && !empty($_POST["search_branch"])) {
        $search_branch = "record_store_code = '" . $_POST["search_branch"] . "'";
    } else {
        $search_branch = '';
    }
    if (isset($_POST["search_area"]) && !empty($_POST["search_area"])) {
        $search_area = "record_branch_area = '" . $_POST["search_area"] . "'";
    } else {
        $search_area = '';
    }

    $conditions = array();
    if (!empty($search_date)) {
        $conditions[] = $search_date;
    }
    if (!empty($search_branch)) {
        $conditions[] = $search_branch;
    }
    if (!empty($search_area)) {
        $conditions[] = $search_area;
    }

    if (!empty($conditions)) {
        $condition = "WHERE " . implode(" AND ", $conditions);
    }
} else {
    $condition = "WHERE CAST(record_input_date AS DATE) = '$currentDate'";
}



$status_query = "SELECT * FROM tbl_input_record $condition";
$status_result = sqlsrv_query($conn, $status_query);

if ($status_result) {
    $status = array();
    while ($row = sqlsrv_fetch_array($status_result, SQLSRV_FETCH_ASSOC)) {
        $status[] = $row;
    }
    sqlsrv_free_stmt($status_result);
} else {
    echo "Error: " . sqlsrv_errors();
}
