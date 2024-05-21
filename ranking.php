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

// Obtener el ranking de las fotos y videos más votados
$sql = "SELECT * FROM content ORDER BY votes DESC";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta SQL: " . $conn->error);
}

$content = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ranking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        .content-container {
            display: inline-block;
            margin: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        img, video {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Ranking de Fotos y Videos</h1>
    <?php foreach ($content as $item): ?>
        <div class="content-container">
            <?php if ($item['type'] == 'photo'): ?>
                <img src="<?php echo htmlspecialchars($item['url']); ?>" alt="Photo">
            <?php else: ?>
                <video src="<?php echo htmlspecialchars($item['url']); ?>" controls></video>
            <?php endif; ?>
            <p>Votes: <?php echo $item['votes']; ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
