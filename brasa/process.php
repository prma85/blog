<?php

include_once '../wp-config.php';
$data = array();
foreach ($_POST as $k => $i) {
    $data[$k] = filter_input(INPUT_POST, $k, FILTER_SANITIZE_STRING);
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_error() || !$conn) {
    echo ("Connection failed: " . mysqli_connect_error);
    exit;
}

$sql = "INSERT INTO `brasa` (`id`, `name`, `email`, `student`) VALUES (NULL, '" . $data['name'] . "', '" . $data['email'] . "', '" . $data['student'] . "')";
$result = mysqli_query($conn, $sql);

echo $result;
