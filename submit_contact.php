<!-- submit_contact.php -->
<?php
if (
    (!isset($_GET['email']) || !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) 
    || (!isset($_GET['message']) || empty($_GET['message']))
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
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
                <p class="card-text"><b>Email</b> : <?php echo $_GET['email']; ?> </p>
                <p class="card-text"><b>Message</b> : <?php echo $_GET['message']; ?> </p>
            </div>
        </div>
    </div>

</body>
</html>
