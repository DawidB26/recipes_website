<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Najpyszniejsze Przepisy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
require_once "includes/db.php";
require_once "blocks/header.php";

// Pobieranie kategorii
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $keyword = $_GET['keyword'] ?? '';
    $category = $_GET['category'] ?? '';
    $prep_time = $_GET['prep_time'] ?? '';

    // Podstawowe zapytanie SQL
    $sql = "SELECT r.* 
            FROM recipe_overview r
            LEFT JOIN recipe_categories rc ON r.recipe_id = rc.recipe_id
            LEFT JOIN categories c ON rc.category_id = c.category_id
            WHERE 1=1";

    $params = [];
    if (!empty($keyword)) {
        $sql .= " AND (r.recipe_title LIKE :keyword OR r.description LIKE :keyword)";
        $params[':keyword'] = "%$keyword%";
    }
    if (!empty($category)) {
        $sql .= " AND c.name = :category";
        $params[':category'] = $category;
    }
    if (!empty($prep_time)) {
        $sql .= " AND r.prep_time <= :prep_time";
        $params[':prep_time'] = $prep_time;
    }

    // Usuwanie duplikatów wyników w przypadku wielu kategorii dla jednego przepisu
    $sql .= " GROUP BY r.recipe_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll();
}
?>
    <section id="content">
	
		<div class="recipes">
        <h1>Wyszukiwarka Przepisów</h1>
    <form method="GET" action="search.php">
        <input type="text" name="keyword" placeholder="Słowo kluczowe" value="<?= htmlspecialchars($keyword ?? '') ?>">
        <select name="category">
            <option value="">Wszystkie kategorie</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['name']) ?>" <?= ($cat['name'] === ($category ?? '')) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="prep_time" placeholder="Maksymalny czas przygotowania (minuty)" value="<?= htmlspecialchars($prep_time ?? '') ?>">
        <button type="submit">Szukaj</button>
    </form>

    <div class="recipe-results">
        <?php if (!empty($recipes)): ?>
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe">
                    <h3><?= htmlspecialchars($recipe['recipe_title']) ?></h3>
                    <p><?= htmlspecialchars($recipe['description']) ?></p>
                    <a href="detailed.php?id=<?= $recipe['recipe_id'] ?>">Zobacz przepis</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nie znaleziono przepisów.</p>
        <?php endif; ?>
        </div>        
    </section>
    <?php require_once "blocks/login-modal.php"; ?>
    <?php require_once "blocks/register-modal.php"; ?>

    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>