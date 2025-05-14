<?php
include 'db_conn.php';

if (isset($_POST['edit_brand_button'])) {
  $edit_brand_id = $_POST['edit_brand_id'];
  $edit_brand = $_POST['edit_brand'];

  $update_brand = "UPDATE tbl_store_cctv
                SET brand_name = '$edit_brand', 
                WHERE brand_id = '$edit_brand_id'";

  // Perform the query
  $update_brand_result = sqlsrv_query($conn, $update_brand);

  if ($update_brand_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Updated a Brand.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Failed to Update Brand.");
                </script>';
  }
}
