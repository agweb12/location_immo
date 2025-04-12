<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $h1 ?></title>
    <meta name="description" content="<?= $description ?>">
    <script src="https://kit.fontawesome.com/b83fa86058.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= RACINE_SITE ?>assets/css/root.css">
    <link rel="stylesheet" href="<?= RACINE_SITE ?>assets/css/style.css">
    <?= $bootstrapHeader ?>
</head>

<body>
    <section class="section-primary">
        <nav id="navbar">
            <a href="<?= RACINE_SITE ?>" class="logo"><img src="<?= RACINE_SITE ?>assets/img/icon-deal.png" alt="logo immo"> Location Immo</a>
            <ul>
                <li><a class="navigation" href="<?= RACINE_SITE ?>">Accueil</a></li>
                <li><a class="navigation" href="<?= RACINE_SITE ?>adverts.php">Toutes les annonces</a></li>
                <li><a class="navigation" href="<?= RACINE_SITE ?>contact.php">Contactez-Nous</a></li>
            </ul>
            <a href="<?= RACINE_SITE ?>addAdvert.php" class="bouton-primary">Ajouter une annonce</a>
        </nav>