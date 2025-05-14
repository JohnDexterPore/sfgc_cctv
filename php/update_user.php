<?php
include 'db_conn.php';

if (isset($_POST['edit_user_button'])) {
  $user_id = $_POST['edit_id'];
  $employee_number = $_POST['edit_employee_number'];
  $fullname = $_POST['edit_fullname'];
  $email = $_POST['edit_email'];
  $password = $_POST['edit_password'];
  $branch = $_POST['edit_branch'];
  $designation = $_POST['edit_designation'];
  $user_type = $_POST['edit_user_type'];
  $user_status = $_POST['edit_user_status'];

  $update_user = "UPDATE tbl_user 
                SET user_employee_number = '$employee_number', 
                    user_email = '$email', 
                    user_password = '$password', 
                    user_fullname = '$fullname', 
                    user_branch = '$branch', 
                    user_designation = '$designation', 
                    user_type = '$user_type',
                    user_status = '$user_status' 
                WHERE user_id = '$user_id'";

  // Perform the query
  $update_user_result = sqlsrv_query($conn, $update_user);

  if ($update_user_result) {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/user.php";
                    alert("Updated a User.");
                </script>';
  } else {
    echo '<script>
                    window.location.href = "/sfgc_cctv/pages/user.php";
                    alert("Failed to Update User.");
                </script>';
  }
}
