<?php
include 'db_conn.php';

if (!isset($_SESSION)) {
  session_start();
}

$currentDate = date('Y-m-d');

$user_type = $_SESSION['user_type'];
$user_branch = $_SESSION['user_branches'];
$selected_branch = 11;


$branch_name_new = "";
if ($user_type == 1) {
  $selected_branch = $user_branch[0];
}
$selected_date = $currentDate;

if (isset($_POST["dashboard_button"])) {
  if (isset($_POST["dashbaord_branch"]) && !empty($_POST["dashbaord_branch"])) {
    $selected_branch = $_POST["dashbaord_branch"];
  }
  if (isset($_POST["date"]) && !empty($_POST["date"])) {
    $selected_date = $_POST["date"];
  }
}
$currentDate = $selected_date;
$last7Days = date('Y-m-d', strtotime('-6 days', strtotime($currentDate)));

for ($i = 0; $i <= 6; $i++) {
  $dateArray[] = date('Y-m-d', strtotime("+$i days", strtotime($last7Days)));
}
$data = array();

$selected_branch = sprintf('%04d', $selected_branch);
for ($i = 0; $i < 7; $i++) {
  $condition = "WHERE record_store_code = '$selected_branch' AND CAST(record_input_date AS DATE) = '" . $dateArray[$i] . "'";
  $dashboard_query = "SELECT record_cctv_working, record_cctv_not_working FROM tbl_input_record $condition";
  $dashboard_result = sqlsrv_query($conn, $dashboard_query);
  if ($dashboard_result) {
    $row = sqlsrv_fetch_array($dashboard_result, SQLSRV_FETCH_ASSOC);
    $dateObj = new DateTime($dateArray[$i]);
    $formatted_date = $dateObj->format('F j');
    if ($row) {
      $data[$i][0] = $formatted_date;
      $data[$i][1] = $row['record_cctv_working'];
      $data[$i][2] = $row['record_cctv_not_working'];
    } else {
      $data[$i][0] = $formatted_date;
      $data[$i][1] = 0;
      $data[$i][2] = 0;
    }
    sqlsrv_free_stmt($dashboard_result);
  } else {
    echo "Error: " . sqlsrv_errors();
  }
}

$fetch_name = "SELECT * FROM tbl_store_cctv WHERE cctv_store_code = '$selected_branch'";
$name_result = sqlsrv_query($conn, $fetch_name);
$row = sqlsrv_fetch_array($name_result, SQLSRV_FETCH_ASSOC);
$branch_name_new = $row['cctv_branch'];

$dashboard_data = json_encode($data);

$fetch_working = "SELECT * FROM tbl_input_record WHERE CAST(record_input_date AS DATE) = '$currentDate' AND record_cctv_remarks = 0";
$working_result = sqlsrv_query($conn, $fetch_working);
$compliant_count = sqlsrv_has_rows($working_result);

if ($working_result) {
  $working_data = array();
  while ($row = sqlsrv_fetch_array($working_result, SQLSRV_FETCH_ASSOC)) {
    $working_data[] = $row;
  }
  sqlsrv_free_stmt($working_result);
} else {
  echo "Error: " . sqlsrv_errors();
}

$fetch_working = "SELECT * FROM tbl_input_record WHERE CAST(record_input_date AS DATE) = '$currentDate' AND record_cctv_remarks = 0";
$working_result = sqlsrv_query($conn, $fetch_working);

if ($working_result) {
  $working_data = array();
  while ($row = sqlsrv_fetch_array($working_result, SQLSRV_FETCH_ASSOC)) {
    $working_data[] = $row;
  }
  $compliant_count = count($working_data);
  sqlsrv_free_stmt($working_result);
} else {
  echo "Error: " . sqlsrv_errors();
}
