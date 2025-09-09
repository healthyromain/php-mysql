<!-- submit_contact.php --> 
<?php
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {

    if ($_FILES['screenshot']['size'] <= 1000000) {

        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

        if (in_array($extension, $allowedExtensions)) {

            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }

            $counter = 1;
            do {
                $newFileName = $counter . '.' . $extension;
                $destination = 'uploads/' . $newFileName;
                $counter++;
            } while (file_exists($destination));

            if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $destination)) {
                echo "L'envoi a bien été effectué sous le nom : $newFileName";
            } else {
                echo "Erreur lors de l'envoi du fichier.";
            }

        } else {
            echo "Extension non autorisée.";
        }

    } else {
        echo "Le fichier est trop volumineux (max 1 Mo).";
    }

} else {
    echo "Aucun fichier envoyé ou erreur lors de l'envoi.";
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
