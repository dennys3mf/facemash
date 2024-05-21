<?php
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'];
$content_id = $data['content_id'];
$watch_time = $data['watch_time'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facemash";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "INSERT INTO view_history (user_id, content_id, watch_time) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $user_id, $content_id, $watch_time);
$stmt->execute();

?>