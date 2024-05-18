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

// Obtener dos fotos al azar
$sql = "SELECT * FROM photos ORDER BY RAND() LIMIT 2";
$result = $conn->query($sql);
$photos = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $winnerId = $_POST['winner_id'];
    if (filter_var($winnerId, FILTER_VALIDATE_INT)) {
        $stmt = $conn->prepare("UPDATE photos SET votes = votes + 1 WHERE id = ?");
        $stmt->bind_param("i", $winnerId);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Facemash</title>
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
            opacity: 1;
            transition: opacity 0.5s ease;
        }
        img {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
        }
        button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .ranking-link {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .ranking-link:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function vote(winnerId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "vote.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    updateImages(response.photos);
                }
            };
            xhr.send("winner_id=" + winnerId);
        }

        function updateImages(photos) {
            var containers = document.querySelectorAll('.photo-container');
            containers.forEach(function (container, index) {
                container.style.opacity = 0;
            });

            setTimeout(function () {
                containers.forEach(function (container, index) {
                    var img = container.querySelector('img');
                    img.src = photos[index].url;
                    container.querySelector('button').value = photos[index].id;
                    container.style.opacity = 1;
                });
            }, 500);
        }
    </script>
</head>
<body>
    <h1>Facemash</h1>
    <div class="photo-container">
        <img src="<?php echo htmlspecialchars($photos[0]['url']); ?>" alt="Photo">
        <button onclick="vote(<?php echo $photos[0]['id']; ?>)">Vote</button>
    </div>
    <div class="photo-container">
        <img src="<?php echo htmlspecialchars($photos[1]['url']); ?>" alt="Photo">
        <button onclick="vote(<?php echo $photos[1]['id']; ?>)">Vote</button>
    </div><br>
    <a class="ranking-link" href="ranking.php">View Ranking</a>
</body>
</html>
