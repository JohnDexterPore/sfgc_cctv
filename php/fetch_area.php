<?php
include 'db_conn.php';

$cctv_area_query = "SELECT DISTINCT cctv_area FROM tbl_store_cctv";
$cctv_area_result = sqlsrv_query($conn, $cctv_area_query);

if ($cctv_area_result) {
  $cctv_area = array();
  while ($row = sqlsrv_fetch_array($cctv_area_result, SQLSRV_FETCH_ASSOC)) {
    $cctv_area[] = $row;
  }
  sqlsrv_free_stmt($cctv_area_result);
} else {
  echo "Error: " . sqlsrv_errors();
}
