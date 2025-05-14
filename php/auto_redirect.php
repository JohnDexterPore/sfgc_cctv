<?php
include 'db_conn.php';

date_default_timezone_set('Asia/Manila');

if (isset($_COOKIE['cctv_monitoring_user'])) {
  $user_employee_number = $_COOKIE['cctv_monitoring_user'];

  $login_query = "SELECT * FROM tbl_user WHERE user_employee_number = '$user_employee_number'";
  $login_result = sqlsrv_query($conn, $login_query);
  $login_count = sqlsrv_has_rows($login_result);

  if ($login_count) {
    $login_get_result = sqlsrv_fetch_array($login_result, SQLSRV_FETCH_ASSOC);
    $user_id = $login_get_result['user_id'];
    $user_fullname = $login_get_result['user_fullname'];
    $user_employee_number = $login_get_result['user_employee_number'];
    $user_email = $login_get_result['user_email'];
    $user_type = $login_get_result['user_type'];
    $user_designation = $login_get_result['user_designation'];

    $branch_query = "SELECT DISTINCT user_store_code FROM tbl_user WHERE user_employee_number = '$user_employee_number'";
    $branch_result = sqlsrv_query($conn, $branch_query);
    $branch_count = sqlsrv_has_rows($branch_result);

    $branches = array(); // Initialize an empty array to store the results

    if ($branch_count) {
      while ($branch_get_result = sqlsrv_fetch_array($branch_result, SQLSRV_FETCH_ASSOC)) {
        $branches[] = $branch_get_result['user_store_code']; // Add each branch to the array
      }
    }

    // Store user_fullname in the session
    $_SESSION['user_fullname'] = $user_fullname;
    $_SESSION['user_branches'] = $branches;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['user_designation'] = $user_designation;
    $_SESSION['user_employee_number'] = $user_employee_number;

    $name = "cctv_monitoring_user";
    $value = $user_employee_number;
    $expiry = time() + (86400); // Cookie will expire in 30 days
    $path = "/"; // Cookie will be available for the entire domain
    setcookie($name, $value, $expiry, $path);
    $currentDateTime = date('Y-m-d H:i:s');
    $login_query = "UPDATE tbl_user
                    SET user_last_log = '$currentDateTime'
                    WHERE user_id = '$user_id';";
    $login_result = sqlsrv_query($conn, $login_query);
  }
} else {
  session_destroy();
  echo '<script>
                window.location.href = "/sfgc_cctv/index.php";
                alert("Login failed. Invalid username or password!");
            </script>';
}
