<!-- login.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    setcookie('LOGGED_USER', '', time() - 3600, "", "", true, true);
    header("Location: index.php");
    exit;
}

// Connexion
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    foreach ($users as $user) {
        if (
            $user['email'] === $_POST['email']
            && $user['password'] === $_POST['password'] // ⚠️ à remplacer par password_verify() si hash
        ) {
            $_SESSION['LOGGED_USER'] = $user['email'];
            $loggedUser = ['email' => $user['email']];

            setcookie(
                'LOGGED_USER',
                $loggedUser['email'],
                time() + 365 * 24 * 3600,
                "",
                "",
                true,
                true
            );
            break;
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

// Vérification session ou cookie
if (isset($_SESSION['LOGGED_USER'])) {
    $loggedUser = ['email' => $_SESSION['LOGGED_USER']];
} elseif (isset($_COOKIE['LOGGED_USER'])) {
    $loggedUser = ['email' => $_COOKIE['LOGGED_USER']];
}
?>

<?php if (!isset($loggedUser)): ?>
    <div class="card shadow-lg p-4 border-1 rounded-4" style="max-width: 420px; margin:auto;">
        <h3 class="text-center mb-4 fw-bold">Connexion</h3>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input
                    type="email"
                    class="form-control form-control-lg rounded-3"
                    id="email"
                    name="email"
                    placeholder="you@exemple.com"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Mot de passe</label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control form-control-lg rounded-start-3"
                        id="password"
                        name="password"
                        required
                    >
                    <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassword()">
                        👁
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                Connexion
            </button>
        </form>
    </div>

    <script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
    </script>
<?php endif; ?>