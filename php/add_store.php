<?php
include 'db_conn.php';

if (isset($_POST['add_store_button'])) {
  $cctv_branch = $_POST['cctv_branch'];
  $area_id = $_POST['area_id'];
  $cctv_type = $_POST['cctv_type'];
  $serial = $_POST['serial'];
  $count = $_POST['count'];
  $status = $_POST['cctv_status'];
  $store_code = $_POST['cctv_store_code'];
  $store_code = sprintf('%04d', $store_code);

  $add_store = "INSERT INTO tbl_store_cctv (
                      cctv_serial, 
                      cctv_branch, 
                      cctv_type, 
                      cctv_count, 
                      cctv_area,
                      cctv_status,
                      cctv_store_code)
                  VALUES (
                      '$serial',
                      '$cctv_branch',
                      '$cctv_type',
                      '$count',
                      '$area_id',
                      '$status',
                      '$store_code')";

  // Perform the query
  $add_store_result = sqlsrv_query($conn, $add_store);

  if ($add_store_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Added a Branch.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Failed to add Branch.");
                </script>';
  }
}

if (isset($_GET['branch_id'])) {
  $branch_id = $_GET['branch_id'];

  $sql = "SELECT 
        cctv_serial, 
        cctv_branch, 
        cctv_type, 
        cctv_count, 
        cctv_area,
        cctv_status,
        cctv_store_code FROM tbl_store_cctv WHERE cctv_id = ?";
  $params = array($branch_id);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $store_code = $row['cctv_store_code'];
    $store_code = sprintf('%04d', $store_code);
    // Fetch user data and return as JSON
    $branchArray = array(
      'cctv_status' => $row['cctv_status'],
      'cctv_serial' => $row['cctv_serial'],
      'cctv_branch' => $row['cctv_branch'],
      'cctv_type' => $row['cctv_type'],
      'cctv_count' => $row['cctv_count'],
      'cctv_area' => $row['cctv_area'],
      'cctv_store_code' => $store_code
    );
    echo json_encode($branchArray);
  } else {
    // User not found
    echo json_encode(array('error' => 'User not found'));
  }
} else {
  // No ID provided
  echo json_encode(array('error' => 'No ID provided'));
}
