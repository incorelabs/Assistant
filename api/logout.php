<?php
session_start();

$response = array();

if (isset($_SESSION['s_id'])) {
    session_unset();
    session_destroy();

    $response['status'] = 1;
    $response['message'] = "Logout Successful";
}

echo json_encode($response);
?>