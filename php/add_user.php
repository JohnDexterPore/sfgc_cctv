<?php
include 'db_conn.php';

if (isset($_POST['add_user_button'])) {
  $employee_number = $_POST['employee_number'];
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $branch = $_POST['branch'];
  $designation = $_POST['designation'];
  $user_type = $_POST['user_type'];
  $reg_by = $_POST['reg_by'];

  $store_code_query = "SELECT * FROM tbl_store_cctv WHERE cctv_branch = '$branch'";
  $store_code_query_result = sqlsrv_query($conn, $store_code_query);

  $condition = "";
  $store_code = "";
  $value = '';

  if ($store_code_row = sqlsrv_fetch_array($store_code_query_result, SQLSRV_FETCH_ASSOC)) {
    $store_code = $store_code_row['cctv_store_code'];
    $condition = ", user_store_code";
    $value = ", '$store_code'";
  }

  $add_user = "INSERT INTO tbl_user (
                  user_employee_number, 
                  user_email, 
                  user_password, 
                  user_fullname, 
                  user_branch, 
                  user_designation, 
                  user_type,
                  user_reg_by,
                  user_status $condition)
              VALUES (
                  '$employee_number',
                  '$email',
                  '$password',
                  '$fullname',
                  '$branch',
                  '$designation',
                  '$user_type',
                  '$reg_by',
                  '0' $value)";

  // Perform the query
  $add_user_result = sqlsrv_query($conn, $add_user);

  if ($add_user_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/user.php";
                    alert("Added a User.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/user.php";
                    alert("Failed to add User.");
                </script>';
  }
}

if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  $sql = "SELECT 
        user_id,
        user_employee_number,
        user_email,
        user_password,
        user_fullname,
        user_branch,
        user_designation,
        user_type,
        user_status FROM tbl_user WHERE user_id = ?";
  $params = array($userId);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Fetch user data and return as JSON
    $userArray = array(
      'user_id' => $row['user_id'],
      'user_employee_number' => $row['user_employee_number'],
      'user_email' => $row['user_email'],
      'user_password' => $row['user_password'],
      'user_fullname' => $row['user_fullname'],
      'user_branch' => $row['user_branch'],
      'user_designation' => $row['user_designation'],
      'user_type' => $row['user_type'],
      'user_status' => $row['user_status']
    );
    echo json_encode($userArray);
  } else {
    // User not found
    echo json_encode(array('error' => 'User not found'));
  }
} else {
  // No ID provided
  echo json_encode(array('error' => 'No ID provided'));
}
