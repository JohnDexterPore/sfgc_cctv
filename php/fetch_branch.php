<?php
include 'db_conn.php';

$branch_query = "SELECT * FROM tbl_store_cctv ORDER BY cctv_branch ASC";
$branch_result = sqlsrv_query($conn, $branch_query);
$branches = array();
while ($row = sqlsrv_fetch_array($branch_result, SQLSRV_FETCH_ASSOC)) {
  $branches[] = $row;
}
$branch_count = count($branches);
