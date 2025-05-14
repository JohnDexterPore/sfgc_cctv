<?php
include 'db_conn.php';

if (isset($_POST['edit_branch_button'])) {
  $edit_cctv_id = $_POST['edit_cctv_id'];
  $edit_cctv_branch = $_POST['edit_cctv_branch'];
  $edit_area_id = $_POST['edit_area_id'];
  $edit_cctv_type = $_POST['edit_cctv_type'];
  $edit_serial = $_POST['edit_serial'];
  $edit_count = $_POST['edit_count'];
  $edit_cctv_status = $_POST['edit_cctv_status'];

  $update_branch = "UPDATE tbl_store_cctv
                SET cctv_serial = '$edit_serial', 
                    cctv_branch = '$edit_cctv_branch', 
                    cctv_area = '$edit_area_id', 
                    cctv_type = '$edit_cctv_type', 
                    cctv_count = '$edit_count', 
                    cctv_status = '$edit_cctv_status'
                WHERE cctv_id = '$edit_cctv_id'";

  // Perform the query
  $update_branch_result = sqlsrv_query($conn, $update_branch);

  if ($update_branch_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Updated a Branch.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Failed to Update Branch.");
                </script>';
  }
}
