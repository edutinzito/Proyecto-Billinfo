<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $genero_musical = $_POST['genero_musical'];

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

        echo "<h1>La semana más exitosa para el género " . htmlspecialchars($genero_musical) . "</h1>";

        // Preparar la consulta SQL con el cruce de tablas
        $stmt = $pdo->prepare("
            SELECT 
                ts.semana, 
                COUNT(ts.cancion) AS cantidad_canciones
            FROM 
                top_semanal_spotify ts, 
                artistas_consolidados ac
            WHERE 
                ts.nombre_artista = ac.nombre
                AND ac.genero_musical = :genero_musical
            GROUP BY 
                ts.semana
            ORDER BY 
                cantidad_canciones DESC
            LIMIT 1;
        ");
        
        // Ejecutar la consulta
        $stmt->execute(['genero_musical' => $genero_musical]);

        // Mostrar resultados
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo "<p>Semana: " . htmlspecialchars($result['semana']) . "<br>";
            echo "Cantidad de canciones en el top: " . htmlspecialchars($result['cantidad_canciones']) . "</p>";
        } else {
            echo "<p>No se encontraron resultados para el género seleccionado.</p>";
        }

        // Enlace para volver a realizar otra consulta
        echo '<br><a href="genero.php">Realizar otra consulta</a>';

    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>
