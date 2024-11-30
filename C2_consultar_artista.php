<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artista = $_POST['artista'];

    try {
        // Configuración de la base de datos
        $host = 'localhost';
        $port = '5432';
        $dbname = 'BillbInfo';
        $user = 'postgres';
        $password = 'phacido97';

        // Crear conexión usando PDO
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<h1>Las 5 canciones más populares de " . htmlspecialchars($artista) . "</h1>";

        // Realizar la consulta para obtener las 5 canciones más populares sumando las reproducciones totales
        $stmt = $pdo->prepare("SELECT cancion, SUM(streams) AS total_streams 
                               FROM top_semanal_spotify 
                               WHERE nombre_artista = :artista 
                               GROUP BY cancion 
                               ORDER BY total_streams DESC 
                               LIMIT 5");
        $stmt->execute(['artista' => $artista]);

        // Mostrar los resultados
        echo "<ol>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row['cancion']) . " - " . htmlspecialchars($row['total_streams']) . " streams totales</li>";
        }
        echo "</ol>";

        // Enlace para volver a realizar otra consulta
        echo '<br><a href="artistas.php">Realizar otra consulta</a>';

    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>
