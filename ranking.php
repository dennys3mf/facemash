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

// Obtener las fotos ordenadas por votos
$sql = "SELECT * FROM photos ORDER BY votes DESC";
$result = $conn->query($sql);
$photos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ranking - Facemash</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        .photo-container {
            display: inline-block;
            margin: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }
        .votes {
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }
        .ranking-link {
            position: absolute; /* Agrega esta línea */
        top: 10px; /* Agrega esta línea */
        right: 10px; /* Agrega esta línea */
            display: inline-block;
            margin-top: 70px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

    </style>
</head>
<body>
    <h1>Ranking - Facemash</h1>
    <a class="ranking-link" href="index.php">Volver a votar</a>
    <?php foreach ($photos as $photo): ?>
        <div class="photo-container">
            <img src="<?php echo htmlspecialchars($photo['url']); ?>" alt="Photo">
            <div class="votes">Votes: <?php echo $photo['votes']; ?></div>
        </div>
    <?php endforeach; ?>
    <br>
</body>
</html>

<?php
$conn->close();
?>
