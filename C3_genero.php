<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta por Género Musical</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <h1>Consulta 3: Géneros Musicales</h1>
    </header>
    <nav>
        <a href="../index.php">Menú Principal</a>
    </nav>
    <main>
        <form action="consultar_genero.php" method="POST">
            <label for="genero_musical">Elige un género:</label>
            <select name="genero_musical" id="genero_musical" required>
                <option value="">Seleccione un género</option>
                <?php
                try {
                    $host = 'localhost';
                    $port = '5432';
                    $dbname = 'BillbInfo';
                    $user = 'postgres';
                    $password = 'phacido97';

                    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $pdo->query("SELECT DISTINCT genero_musical FROM artistas_consolidados ORDER BY genero_musical ASC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . htmlspecialchars($row['genero_musical']) . '">' . htmlspecialchars($row['genero_musical']) . '</option>';
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
