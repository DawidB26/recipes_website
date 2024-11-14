<?php
// view_table.php
require_once '../includes/db.php';

if (isset($_GET['name'])) {
    $tableName = $_GET['name'];

    // Sprawdzamy, czy tabela lub widok istnieje
    $stmt = $pdo->prepare("SHOW TABLES LIKE :tableName");
    $stmt->execute(['tableName' => $tableName]);

    if ($stmt->rowCount() > 0) {
        // Jeśli tabela lub widok istnieje, pobieramy dane
        $stmt = $pdo->prepare("SELECT * FROM `$tableName`");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $data = [];
        $error = "Tabela lub widok o nazwie '$tableName' nie istnieje w bazie danych.";
    }
} else {
    $data = [];
    $error = "Nie podano nazwy tabeli/widoku.";
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zawartość tabeli/widoku</title>
</head>
<body>
    <h1>Zawartość tabeli/widoku: <?= htmlspecialchars($tableName) ?></h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (!empty($data)): ?>
        <table border="1">
            <thead>
                <tr>
                    <?php
                    // Wyświetlamy nagłówki tabeli
                    $columns = array_keys($data[0]);
                    foreach ($columns as $column) {
                        echo "<th>" . htmlspecialchars($column) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?= htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="admin.php">Powrót do listy tabel i widoków</a>
</body>
</html>
