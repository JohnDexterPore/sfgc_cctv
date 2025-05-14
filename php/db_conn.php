<?php
$serverName = "172.16.200.215";
$connectionOptions = array(
    "Database" => "CCTV_Monitoring",
    "Uid" => "sa",
    "PWD" => "b1@dmin2022"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die('Connection failed: ' . sqlsrv_errors());
}
