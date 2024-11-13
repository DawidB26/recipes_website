<?php
// admin.php
require_once '../includes/db.php';

session_start();

// Zapytanie do pobrania tabel i widoków
$query = "
    (SELECT table_name AS name FROM information_schema.tables WHERE table_schema = 'strona_z_przepisami')
    UNION
    (SELECT table_name AS name FROM information_schema.views WHERE table_schema = 'strona_z_przepisami');
";

$stmt = $pdo->query($query);
$tablesAndViews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tabele i Widoki</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <h2>Spis tabel i widoków</h2>
    <ul>
        <?php foreach ($tablesAndViews as $item): ?>
            <li>
                <a href="view_table.php?name=<?= urlencode($item['name']) ?>"><?= htmlspecialchars($item['name']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
