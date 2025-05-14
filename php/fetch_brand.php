<?php
include 'db_conn.php';

$brand_query = "SELECT * FROM mtbl_brand";
$brand_result = sqlsrv_query($conn, $brand_query);

if ($brand_result) {
  $brands = array();
  while ($row = sqlsrv_fetch_array($brand_result, SQLSRV_FETCH_ASSOC)) {
    $brands[] = $row;
  }
  sqlsrv_free_stmt($brand_result);
} else {
  echo "Error: " . sqlsrv_errors();
}
