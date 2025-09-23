<?php
session_start();
include_once('mysql.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

// Initialiser message d'erreur ou succès
$message = null;

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $recipe = trim($_POST['recipe']);
    $author = $_SESSION['LOGGED_USER'];  // ✅ correction ici

    // Vérifier que les champs ne sont pas vides
    if ($title === '' || $recipe === '') {
        $message = '<div class="alert alert-danger">Veuillez remplir tous les champs.</div>';
    } else {
        // Insérer la recette en base
        $sql = 'INSERT INTO recipes (title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, 1)';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'recipe' => $recipe,
            'author' => $author
        ]);

        $message = '<div class="alert alert-success">Recette ajoutée avec succès ✅</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<header class="bg-dark text-white p-3">
    <div class="container">
        <?php include_once('header.php'); ?>
    </div>
</header>

<main class="container py-4">
    <h1 class="mb-4 text-center">🍳 Ajouter une nouvelle recette</h1>

    <?php if ($message) echo $message; ?>

    <form method="post" action="ajout_recette.php" class="card shadow-sm p-4">
        <div class="mb-3">
            <label for="title" class="form-label">Titre de la recette</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="recipe" class="form-label">Recette</label>
            <textarea class="form-control" id="recipe" name="recipe" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
    </form>
</main>

<footer class="bg-dark text-white text-center p-3 mt-auto">
    <?php include_once('footer.php'); ?>
</footer>

</body>
</html>