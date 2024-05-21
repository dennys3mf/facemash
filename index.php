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

$sql = "SELECT * FROM content ORDER BY RAND() LIMIT 2";
$result = $conn->query($sql);
$contents = $result->fetch_all(MYSQLI_ASSOC);

$user_id = 1; // Asumiendo que el ID del usuario está en sesión o se obtiene de otra manera
$_SESSION['user_id'] = $user_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facemash</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Facemash</h1>
    <?php foreach ($contents as $content): ?>
        <div class="photo-container">
            <?php if ($content['type'] == 'photo'): ?>
                <img src="<?php echo htmlspecialchars($content['url']); ?>" alt="Content">
            <?php else: ?>
                <video id="video-<?php echo $content['content_id']; ?>" src="<?php echo htmlspecialchars($content['url']); ?>" controls></video>
            <?php endif; ?>
            <button onclick="vote(<?php echo $content['content_id']; ?>)">Vote</button>
        </div>
    <?php endforeach; ?>
            </br>
    <a class="ranking-link" href="ranking.php">View Ranking</a>

    <script src="./js/scripts.js"></script>
</body>
</html>
