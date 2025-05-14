<?php
include 'db_conn.php';

if (isset($_GET['logout'])) {
  $cookieName = "cctv_monitoring_user";
  $cookiePath = "/";
  setcookie($cookieName, "", time() - 1, $cookiePath);
  header("Location: /sfgc_cctv/index.php");
}
