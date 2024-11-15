<?php
require_once '../includes/db.php'; // Połączenie z bazą danych

try {
    // Pobieranie listy tabel i widoków
    $tables = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE' OR Table_type = 'VIEW'")->fetchAll(PDO::FETCH_ASSOC);

    // Sprawdzenie, czy wybrano tabelę do wyświetlenia
    $selectedTable = $_GET['table'] ?? null;
    $tableData = [];
    if ($selectedTable) {
        // Pobieranie danych z wybranej tabeli
        $stmt = $pdo->prepare("SELECT * FROM `$selectedTable` LIMIT 100"); // Ograniczamy do 100 wierszy
        $stmt->execute();
        $tableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Błąd: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny</title>
</head>
<body>
    <h1>Panel administracyjny</h1>

    <!-- Wyświetlanie spisu tabel i widoków -->
    <h2>Spis tabel i widoków</h2>
    <ul>
        <?php foreach ($tables as $table): ?>
            <?php 
                $tableName = $table[array_keys($table)[0]]; // Pobranie nazwy tabeli lub widoku
            ?>
            <li><a href="?table=<?= htmlspecialchars($tableName) ?>"><?= htmlspecialchars($tableName) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <!-- Wyświetlanie zawartości wybranej tabeli -->
    <?php if ($selectedTable): ?>
        <h2>Zawartość tabeli: <?= htmlspecialchars($selectedTable) ?></h2>
        <table border="1">
            <tr>
                <?php if (!empty($tableData)): ?>
                    <!-- Wyświetlanie nagłówków kolumn -->
                    <?php foreach (array_keys($tableData[0]) as $column): ?>
                        <th><?= htmlspecialchars($column) ?></th>
                    <?php endforeach; ?>
                <?php else: ?>
                    <th>Brak danych do wyświetlenia</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($tableData as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?= htmlspecialchars($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
