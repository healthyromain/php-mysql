<?php
session_start();
include_once('mysql.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de recette invalide.');
}
$recipeId = (int)$_GET['id'];

$sql = 'SELECT * FROM recipes WHERE recipe_id = :id AND author = :author';
$stmt = $db->prepare($sql);
$stmt->execute([
    'id' => $recipeId,
    'author' => $_SESSION['LOGGED_USER']
]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    die("Recette introuvable ou vous n'êtes pas autorisé à la modifier.");
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['recipe']);

    if ($title === '' || $content === '') {
        $message = '<div class="alert alert-danger">Veuillez remplir tous les champs.</div>';
    } else {
        $sqlUpdate = 'UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id AND author = :author';
        $updateStmt = $db->prepare($sqlUpdate);
        $updateStmt->execute([
            'title' => $title,
            'recipe' => $content,
            'id' => $recipeId,
            'author' => $_SESSION['LOGGED_USER']
        ]);

        $message = '<div class="alert alert-success">Recette modifiée avec succès ✅</div>';
        // Recharger les nouvelles données
        $recipe['title'] = $title;
        $recipe['recipe'] = $content;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header class="bg-dark text-white p-3">
    <div class="container">
        <?php include_once('header.php'); ?>
    </div>
</header>

<main class="container py-4">
    <h1 class="mb-4 text-center">✏️ Modifier la recette</h1>

    <?php if ($message) echo $message; ?>

    <form method="post" action="edit_recette.php?id=<?php echo $recipeId; ?>" class="card shadow-sm p-4">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="recipe" class="form-label">Recette</label>
            <textarea class="form-control" id="recipe" name="recipe" rows="6" required><?php echo htmlspecialchars($recipe['recipe']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
    </form>
</main>

<footer class="bg-dark text-white text-center p-3 mt-auto">
    <?php include_once('footer.php'); ?>
</footer>

</body>
</html>