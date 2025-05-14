<?php
include 'db_conn.php';

if (isset($_POST['add_brand_button'])) {
  $brand = $_POST['brand'];

  $add_brand = "INSERT INTO mtbl_brand (
                      brand_name)
                  VALUES (
                      '$brand')";

  // Perform the query
  $add_brand_result = sqlsrv_query($conn, $add_brand);

  if ($add_brand_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Added a Brand.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/customize.php";
                    alert("Failed to add Brand.");
                </script>';
  }
}

if (isset($_GET['brand_id'])) {
  $brand_id = $_GET['brand_id'];

  $sql = "SELECT 
        brand_name FROM mtbl_brand WHERE brand_id = ?";
  $params = array($brand_id);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Fetch user data and return as JSON
    $branchArray = array(
      'brand_name' => $row['brand_name']
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


