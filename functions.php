<?php
function isValidRecipe($recipe) {
    return isset($recipe['is_enabled']) && $recipe['is_enabled'];
}

function getRecipes($recipes) {
    $validRecipes = [];
    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $validRecipes[] = $recipe;
        }
    }
    return $validRecipes;
}

function displayAuthor($authorEmail, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $authorEmail) {
            return $user['full_name'] . ' (' . $user['age'] . ' ans)';
        }
    }
    return 'Auteur inconnu';
}
