<!-- login.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['logout'])) {
    session_destroy();

    setcookie('LOGGED_USER', '', time() - 3600, "", "", true, true);

    header("Location: index.php");
    exit;
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    foreach ($users as $user) {
        if (
            $user['email'] === $_POST['email']
            && $user['password'] === $_POST['password']
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

if (isset($_SESSION['LOGGED_USER'])) {
    $loggedUser = ['email' => $_SESSION['LOGGED_USER']];
}
elseif (isset($_COOKIE['LOGGED_USER'])) {
    $loggedUser = ['email' => $_COOKIE['LOGGED_USER']];
}
?>

<?php if (!isset($loggedUser)): ?>
    <form action="index.php" method="POST" class="mb-4">
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
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
    </script>

<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?php echo htmlspecialchars($loggedUser['email']); ?> et bienvenue sur le site !
    </div>

    <form action="index.php" method="POST">
        <button type="submit" name="logout" class="btn btn-danger mt-2">Se déconnecter</button>
    </form>
<?php endif; ?>