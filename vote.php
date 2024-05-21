<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facemash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$winner_id = $_POST['winner_id'];
$user_id = $_SESSION['user_id'];

$query = "UPDATE content SET votes = votes + 1 WHERE content_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $winner_id);
$stmt->execute();

// Recomendación basada en los tags de los contenidos más vistos por el usuario
$query = "
    SELECT c.tags 
    FROM view_history vh 
    JOIN content c ON vh.content_id = c.content_id 
    WHERE vh.user_id = ? 
    ORDER BY vh.watch_time DESC 
    LIMIT 3";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tags = [];

while ($row = $result->fetch_assoc()) {
    $tags = array_merge($tags, json_decode($row['tags']));
}
$tags = array_unique($tags);

$tags_placeholder = implode(',', array_fill(0, count($tags), '?'));
$query = "
    SELECT content_id, url, type 
    FROM content 
    WHERE JSON_OVERLAPS(tags, JSON_ARRAY($tags_placeholder)) 
    ORDER BY RAND() 
    LIMIT 2";
$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('s', count($tags)), ...$tags);
$stmt->execute();
$result = $stmt->get_result();
$new_contents = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode(['contents' => $new_contents]);
