<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Canciones por Artista</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <h1>Consulta 2: Canciones por Artista</h1>
    </header>
    <nav>
        <a href="../index.php">Menú Principal</a>
    </nav>
    <main>
        <form action="consultar_artista.php" method="POST">
            <label for="artista">Selecciona un artista:</label>
            <select name="artista" id="artista" required>
                <?php
                try {
                    $host = 'localhost';
                    $port = '5432';
                    $dbname = 'BillbInfo';
                    $user = 'postgres';
                    $password = 'phacido97';

                    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->query("SELECT DISTINCT nombre_artista FROM top_semanal_spotify ORDER BY nombre_artista ASC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['nombre_artista']) . "'>" . htmlspecialchars($row['nombre_artista']) . "</option>";
                    }
                } catch (PDOException $e) {
                    echo "Error en la conexión: " . $e->getMessage();
                }
                ?>
            </select>
            <button type="submit">Consultar</button>
        </form>
    </main>
    <footer>
        &copy; 2024 Aplicación de Música
    </footer>
</body>
</html>
