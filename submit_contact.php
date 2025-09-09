<!-- submit_contact.php --> 
<?php
if (
    (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    || (!isset($_POST['message']) || empty($_POST['message']))
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

$uploadMessage = '';
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
    if ($_FILES['screenshot']['size'] <= 1000000) {
        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = strtolower($fileInfo['extension']); // sécurité : tout en minuscule
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        
        if (in_array($extension, $allowedExtensions)) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            $destination = 'uploads/' . basename($_FILES['screenshot']['name']);
            if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $destination)) {
                $uploadMessage = "L'envoi du fichier a bien été effectué !";
            } else {
                $uploadMessage = "Erreur lors de l'envoi du fichier.";
            }
        } else {
            $uploadMessage = "Extension non autorisée. Seuls jpg, jpeg, gif et png sont acceptés.";
        }
    } else {
        $uploadMessage = "Le fichier est trop volumineux (max 1 Mo).";
    }
}
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
