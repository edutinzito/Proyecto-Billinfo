<?php
if (isset($_POST['semana'])) {
    $semanaSeleccionada = $_POST['semana'];

    try {
        // Configuración de la conexión
        $host = 'localhost';
        $port = '5432';
        $dbname = 'BillbInfo';
        $user = 'postgres';
        $password = 'phacido97';

        // Crear conexión usando PDO
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Realizar la consulta para obtener las canciones más populares de la semana seleccionada
        $stmt = $pdo->prepare("SELECT cancion, nombre_artista, streams FROM top_semanal_spotify WHERE semana = :semana ORDER BY streams DESC");
        $stmt->bindParam(':semana', $semanaSeleccionada, PDO::PARAM_STR);
        $stmt->execute();

        // Mostrar resultados
        echo "<h1>Canciones más populares de la semana: " . htmlspecialchars($semanaSeleccionada) . "</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Canción</th><th>Artista</th><th>Streams</th></tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['cancion']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nombre_artista']) . "</td>";
            echo "<td>" . htmlspecialchars($row['streams']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Botón para regresar al formulario
        echo "<br><form action='index.php' method='get'>";
        echo "<button type='submit'>Consultar otra semana</button>";
        echo "</form>";
        
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
} else {
    echo "Por favor selecciona una semana.";
}
?>

