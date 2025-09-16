<!-- index.php -->
<?php
session_start();
?>
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
    <style>
        .hero {
            background: linear-gradient(135deg, #ff8a00, #da1b60);
            color: white;
            padding: 2.5rem 1.5rem;
            text-align: center;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .hero h1 {
            font-size: 2rem;
            font-weight: 900;
        }
        .hero p {
            font-size: 1rem;
            margin-top: 0.5rem;
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        footer {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Header -->
    <header class="bg-dark text-white p-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <?php include_once('header.php'); ?>
        </div>
    </header>

    <!-- Main -->
    <main class="container flex-grow-1">
        <!-- inclusion des variables et fonctions -->
        <?php
        include_once('variables.php');
        include_once('functions.php');
        ?>

        <?php include_once('login.php'); ?>

        <!-- Hero -->
        <section class="hero">
            <h1>Bienvenue sur mon site de recettes</h1>
            <p>Découvrez et partagez des recettes gourmandes avec la communauté !</p>
        </section>

        <?php if (isset($loggedUser)): ?>
            <div class="alert alert-success d-flex flex-column align-items-center" role="alert">
                <p class="mb-2">
                    Bonjour <?php echo htmlspecialchars($loggedUser['email']); ?> et bienvenue sur le site !
                </p>
                <form action="index.php" method="POST" class="w-100 text-center">
                    <button type="submit" name="logout" class="btn btn-danger mt-2">
                        Se déconnecter
                    </button>
                </form>
            </div>

            <h2 class="mb-4 text-center">Mes recettes</h2>
            <div class="row justify-content-center">
                <?php
                // Filtrer les recettes pour ne garder que celles de l'utilisateur connecté
                $userRecipes = array_filter($recipes, function($recipe) use ($loggedUser) {
                    return $recipe['author'] === $loggedUser['email'];
                });
                ?>

                <?php foreach (getRecipes($userRecipes) as $recipe): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <article class="card shadow-sm h-100">
                            <!--
                            <img src="https://source.unsplash.com/600x400/?food,recipe"
                                 class="card-img-top" alt="Image recette">
                            -->
                            <div class="card-body">
                                <h3 class="card-title h5">
                                    <?php echo $recipe['title']; ?>
                                </h3>
                                <p class="card-text text-muted">
                                    <?php echo substr($recipe['recipe'], 0, 120) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer text-muted">
                                Auteur : <?php echo displayAuthor($recipe['author'], $users); ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center mt-4">
                Connectez-vous pour découvrir toutes les recettes gourmandes
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3 mt-auto shadow-sm">
        <?php include_once('footer.php'); ?>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>