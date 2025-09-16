<!-- submit_contact.php --> 
<?php
$name    = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email   = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

// Gestion de l'upload
$uploadMessage = "";

if (isset($_FILES['upload']) && $_FILES['upload']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['upload']['error'] === UPLOAD_ERR_OK) {
        // Dossier de destination (assure-toi qu'il existe et qu'il est accessible en écriture)
        $uploadDir = __DIR__ . "/uploads/";

        // Création du dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Nom du fichier final
        $uploadFile = $uploadDir . basename($_FILES['upload']['name']);

        // Déplacement du fichier temporaire vers le dossier final
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadFile)) {
            $uploadMessage = "Fichier uploadé avec succès : " . htmlspecialchars($_FILES['upload']['name']);
        } else {
            $uploadMessage = "Erreur lors du déplacement du fichier.";
        }
    } else {
        $uploadMessage = "Erreur lors de l'upload (code : " . $_FILES['upload']['error'] . ")";
    }
} else {
    $uploadMessage = "Aucun fichier uploadé.";
}

// Affichage des résultats
echo "<h2>Rappel de vos informations</h2>";
echo "Nom : " . $name . "<br>";
echo "Email : " . $email . "<br>";
echo "Message : " . nl2br($message) . "<br>";
echo "Upload : " . $uploadMessage . "<br>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Contact</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">Message bien reçu !</h1>

    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="card-title">Rappel de vos informations</h5>
            <p class="card-text"><b>Nom</b> : <?php echo $name; ?> </p>
            <p class="card-text"><b>Email</b> : <?php echo $email; ?> </p>
            <p class="card-text"><b>Message</b> : <?php echo $message; ?> </p>
            <?php if ($uploadMessage): ?>
                <p class="card-text text-success"><?php echo $uploadMessage; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>