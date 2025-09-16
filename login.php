<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
    foreach ($users as $user) {
        if (
            $user['email'] === $_POST['email']
            && $user['password'] === $_POST['password']
        ) {
            $loggedUser = ['email' => $user['email']];
            break; // on sort de la boucle si trouvé
        }
    }

    if (!isset($loggedUser)) {
        $errorMessage = sprintf(
            'Les informations envoyées ne permettent pas de vous identifier : (%s / %s)',
            htmlspecialchars($_POST['email']),
            htmlspecialchars($_POST['password'])
        );
    }
}
?>

<?php if (!isset($loggedUser)): ?>
    <form action="index.php" method="POST" class="mb-4">
        <!-- Affichage du message d'erreur -->
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                placeholder="you@exemple.com"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    required
                >
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                    👁
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Connexion</button>
    </form>

    <script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        if (pwd.type === "password") {
            pwd.type = "text";
        } else {
            pwd.type = "password";
        }
    }
    </script>

<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?php echo htmlspecialchars($loggedUser['email']); ?> et bienvenue sur le site !
    </div>
<?php endif; ?>
