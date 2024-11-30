<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canciones Populares por Semana</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Ruta relativa al CSS -->
</head>
<body>
    <header>
        <h1>Consulta 1: Canciones Populares por Semana</h1>
    </header>
    <nav>
        <a href="../index.php">Menú Principal</a>
    </nav>
    <main>
        <form action="consultar.php" method="POST">
            <label for="semana">Selecciona la semana:</label>
            <select name="semana" id="semana">
                <?php
                try {
                    $host = 'localhost';
                    $port = '5432';
                    $dbname = 'BillbInfo';
                    $user = 'postgres';
                    $password = 'phacido97';

                    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->query("SELECT DISTINCT semana FROM top_semanal_spotify ORDER BY semana");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['semana']) . "'>" . htmlspecialchars($row['semana']) . "</option>";
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
