<!-- delete_recette.php -->
<?php
session_start();
include_once('mysql.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

// Vérifier que l'ID est présent et valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de recette invalide.');
}
$recipeId = (int)$_GET['id'];

// Vérifier que la recette appartient bien à l'utilisateur
$sql = 'SELECT * FROM recipes WHERE recipe_id = :id AND author = :author';
$stmt = $db->prepare($sql);
$stmt->execute([
    'id' => $recipeId,
    'author' => $_SESSION['LOGGED_USER']
]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    die("Recette introuvable ou vous n'êtes pas autorisé à la supprimer.");
}

// Suppression
$sqlDelete = 'DELETE FROM recipes WHERE recipe_id = :id AND author = :author';
$deleteStmt = $db->prepare($sqlDelete);
$deleteStmt->execute([
    'id' => $recipeId,
    'author' => $_SESSION['LOGGED_USER']
]);

// Redirection vers l'accueil après suppression
header('Location: index.php?msg=deleted');
exit();