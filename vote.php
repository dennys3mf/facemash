<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "facemash";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $winnerId = $_POST['winner_id'];
    if (filter_var($winnerId, FILTER_VALIDATE_INT)) {
        $stmt = $conn->prepare("UPDATE photos SET votes = votes + 1 WHERE id = ?");
        $stmt->bind_param("i", $winnerId);
        $stmt->execute();
        $stmt->close();
    }

    // Obtener dos nuevas fotos al azar
    $sql = "SELECT * FROM photos ORDER BY RAND() LIMIT 2";
    $result = $conn->query($sql);
    $photos = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['photos' => $photos]);
}

$conn->close();
?>
