<!-- index.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <header class="bg-dark text-white p-3 mb-4">
        <div class="container">
            <?php include_once('header.php'); ?>
        </div>
    </header>

    <main class="container flex-grow-1">
        <!-- inclusion des variables et fonctions -->
        <?php
        include_once('variables.php');
        include_once('functions.php');
        ?>

        <!-- inclusion du formulaire de connexion -->
        <?php include_once('login.php'); ?>

        <h1 class="mb-4 text-center">Bienvenue sur mon site de recettes</h1>

        <!-- affichage des recettes uniquement si connecté -->
        <?php if (isset($loggedUser)): ?>
            <div class="row">
                <?php foreach(getRecipes($recipes) as $recipe) : ?>
                    <div class="col-md-6 mb-4">
                        <article class="card shadow-sm h-100">
                            <div class="card-body">
                                <h3 class="card-title"><?php echo $recipe['title']; ?></h3>
                                <p class="card-text"><?php echo $recipe['recipe']; ?></p>
                            </div>
                            <div class="card-footer text-muted">
                                Auteur : <?php echo displayAuthor($recipe['author'], $users); ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-auto">
        <?php include_once('footer.php'); ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>