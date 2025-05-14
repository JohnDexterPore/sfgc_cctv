<?php
include 'db_conn.php';

if (isset($_POST['add_remarks_button'])) {
  $add_transac_id = $_POST['transac_id'];
  $remarks = $_POST['remarks'];

  $add_remarks_query = "UPDATE tbl_input_record
                        SET record_cctv_remarks = '$remarks'
                        WHERE record_transac_id = '$add_transac_id'";

  $add_remarks_result = sqlsrv_query($conn, $add_remarks_query);
  if ($add_remarks_result) {
    echo '<script>
            window.location.href = "/sfgc_cctv/pages/records.php";
            alert("Added a Remarks.");
          </script>';
  } else {
  }
}


if (!isset($_SESSION)) {
  session_start();
}
$currentDate = date('Y-m-d');
$currentTimeZone = new DateTimeZone('Asia/Manila');
$currentTime = new DateTime('now', $currentTimeZone);
$currentTimeString = $currentTime->format('H:i:s');
$comparisonTime = '13:30:00';
$user_employee_number = $_SESSION['user_employee_number'];
if (isset($_POST['add_status_button'])) {
  $date = $_POST['date'];
  $formatted_date = date('Y-m-d', strtotime($date));
  $branch = 0;
  if (isset($_POST['branch'])) {
    $branch = $_POST['branch'];
  } else {
    $user_branch = $_SESSION['user_branches'];
    $branch = $user_branch[0];
  }
  $branch = sprintf('%04d', $branch);
  $working_cctv = $_POST['working_cctv'];
  $cctv_image = $_FILES['cctv_image'];
  if ($currentTimeString < $comparisonTime) {
    $check_record = "SELECT * FROM tbl_input_record WHERE cast (record_input_date as date) = '$formatted_date' AND record_store_code = '$branch' AND record_cctv_remarks = 0";
    $check_result = sqlsrv_query($conn, $check_record);
    $check_row = sqlsrv_fetch_array($check_result, SQLSRV_FETCH_ASSOC);
    if ($check_row) {
      echo '<script>
          alert("Duplicate submission detected. You have already sent a CCTV status update. 1 \"Complete\" submission only per day...");
          window.location.href = "/sfgc_cctv/pages/records.php";
      </script>';
    } else {
      $fetch_cctv_data = "SELECT * FROM tbl_store_cctv WHERE cctv_store_code = '$branch'";
      $cctv_data_result = sqlsrv_query($conn, $fetch_cctv_data);
      $cctv_data_row = sqlsrv_fetch_array($cctv_data_result, SQLSRV_FETCH_ASSOC);
      $cctv_count = $cctv_data_row['cctv_count'];
      $cctv_branch = $cctv_data_row['cctv_branch'];
      $cctv_area = $cctv_data_row['cctv_area'];
      $cctv_brand = "N/A";
      $cctv_serial = "N/A";

      if ($working_cctv > $cctv_count) {
        echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Error: The number of CCTV working exceeds the total number of CCTV in store.");
                </script>';
      } else {
        if (!is_null($cctv_data_row['cctv_type'])) {
          $cctv_brand = $cctv_data_row['cctv_type'];
        }
        if (!is_null($cctv_data_row['cctv_type'])) {
          $cctv_serial = $cctv_data_row['cctv_serial'];
        }

        $status = '';
        if (isset($_POST['cctv_status_defective'])) {
          $status = 'Defective DVR';
        } elseif (isset($_POST['cctv_status_closed'])) {
          $status = 'Store Closed';
          $reason = $_POST['reason'];
        } else {
          $status = '';
        }

        if ($status ==  '' || $status == 'Defective DVR') {
          $cctv_image_name = $_FILES['cctv_image']['name'];
          $cctv_image_tmp_name = $_FILES['cctv_image']['tmp_name'];
          $cctv_error = $_FILES['cctv_image']['error'];

          $cctv_image_ext = explode('.', $cctv_image_name);
          $cctv_image_ext = strtolower(end($cctv_image_ext));

          if ($cctv_error == 0) {
            $cctv_new_name = uniqid('', true) . "." . $cctv_image_ext;
            $cctv_image_destination = '../image_uploads/' . $cctv_new_name;
            $transaction_date = str_replace('-', '', $formatted_date);
            $transaction_id = $branch . $transaction_date;
            $not_working_cctv = $cctv_count - $working_cctv;
            $add_record = "INSERT INTO tbl_input_record (
                        record_transac_id, 
                        record_input_by, 
                        record_input_date, 
                        record_cctv_name, 
                        record_cctv_working,
                        record_cctv_not_working,
                        record_branch,
                        record_serial_no,
                        record_branch_area,
                        record_store_code,
                        record_file_name,
						            record_cctv_remarks
                        )
                      VALUES (
                        '$transaction_id',
                        '$user_employee_number',
                        '$date',
                        '$cctv_brand',
                        '$working_cctv',
                        '$not_working_cctv',
                        '$cctv_branch',
                        '$cctv_serial',
                        '$cctv_area',
                        '$branch',
                        '$cctv_new_name',
						            0
                      )";
            $add_record_result = sqlsrv_query($conn, $add_record);

            if ($add_record_result && move_uploaded_file($cctv_image_tmp_name, $cctv_image_destination)) {
              echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Record uploaded.");
                  </script>';
            } else {
              echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Error Uploading your file.");
                  </script>';
            }
          }
        } elseif ($status == 'Store Closed') {
          $transaction_date = str_replace('-', '', $formatted_date);
          $transaction_id = $branch . $transaction_date;
          $not_working_cctv = $cctv_count - $working_cctv;
          $add_record = "INSERT INTO tbl_input_record (
                        record_transac_id, 
                        record_input_by, 
                        record_input_date, 
                        record_cctv_name, 
                        record_cctv_working,
                        record_cctv_not_working,
                        record_branch,
                        record_serial_no,
                        record_branch_area,
                        record_store_code,
                        record_file_name,
						            record_cctv_remarks,
                        record_status,
                        record_reason
                        )
                      VALUES (
                        '$transaction_id',
                        '$user_employee_number',
                        '$date',
                        '$cctv_brand',
                        '$working_cctv',
                        '$not_working_cctv',
                        '$cctv_branch',
                        '$cctv_serial',
                        '$cctv_area',
                        '$branch',
                        '',
						            0,
                        '$status',
                        '$reason'
                      )";
          $add_record_result = sqlsrv_query($conn, $add_record);

          if ($add_record_result) {
            echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Record uploaded.");
                  </script>';
          } else {
            echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Error Uploading.");
                  </script>';
          }
        } else {
          echo '<script>
                    window.location.href = "/sfgc_cctv/pages/records.php";
                    alert("Error Uploading.");
                  </script>';
        }
      }
    }
  } else {
    echo '<script>
            window.location.href = "/sfgc_cctv/pages/records.php";
            alert("Error: The submission of cctv status is closed after 1:30 PM.");
          </script>';
  }
}

if (isset($_GET['id'])) {
  $transac_id = $_GET['id'];

  $sql = "SELECT record_branch FROM tbl_input_record WHERE record_transac_id = ?";
  $params = array($transac_id);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Fetch user data and return as JSON
    $userArray = array(
      'record_branch' => $row['record_branch']
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
