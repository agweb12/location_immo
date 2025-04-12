<?php
require_once("inc/functions.inc.php");
$h1 = "Toutes les annonces - Location Immo";
$description = "Découvrez toutes nos annonces de location immobilière sur notre site. Que vous cherchiez un appartement, une maison ou un local commercial, nous avons ce qu'il vous faut.";
$bootstrapHeader = "";
$scriptJS = '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="<?= RACINE_SITE ?>assets/js/script.js"></script>';
$bootstrapFooter = "";
$alerte = "";
$derniere9ImagesAnnonces = afficherDernieres6ImagesAnnonces();

$afficherUneAnnonce = afficherUneAnnonce($_GET['id']);

// Traitement du formulaire de réservation de l'annonce
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_message = htmlspecialchars($_POST['reservation_message']);
    $id_advert = $_GET['id'];

    if (!empty($reservation_message)) {
        $pdo = connexionBDD();
        $sql = "UPDATE advert SET reservation_message = :reservation_message WHERE id_advert = :id";
        $requete = $pdo->prepare($sql);
        $requete->execute(array(
            ':reservation_message' => $reservation_message,
            ':id' => $id_advert
        ));
        $alerte = '<div class="alert-success">Votre message de réservation a été envoyé avec succès.</div>';
        header("refresh: 3; url=adverts.php");
    } else {
        $alerte = '<div class="alert-danger">Veuillez remplir le message de réservation.</div>';
    }
}

require_once("inc/header.inc.php");
?>

<section class="listingproperty" id="advertList">
    <div class="list-title">
        <h2>L'annonce <?= ucfirst($afficherUneAnnonce['title']) ?></h2>
        <p>Retrouvez toutes les informations sur cette annonce.</p>
        <?= $alerte ?>
    </div>
    <div class="rowProperty">
        <div class="showOneProperty">
            <div class="property-box">
                <img src="<?= RACINE_SITE ?>assets/img/<?= $afficherUneAnnonce['photo']?>" alt="image de l'annonce <?= $annonce['id_advert']?>">
                <h4>En <?= ucfirst($afficherUneAnnonce['type']) ?></h4>
                <h5><?= ucfirst($afficherUneAnnonce['type_immobilier']) ?></h5>
                <div class="box-details-property">
                    <div class="details-property">
                        <h6 class="price"><?= $afficherUneAnnonce['price'] ?> €</h6>
                        <h3><?= strtoupper($afficherUneAnnonce['title']) ?> en <?= $afficherUneAnnonce['type'] ?></h3>
                        <div class="location">
                            <i class="fa-solid fa-location-pin" style="color: var(--text-primary);"></i>
                            <p><?= $afficherUneAnnonce['postal_code'] ?>, <?= $afficherUneAnnonce['city'] ?></p>
                        </div>
                    </div>
                    <div class="row-details">
                        <div class="details">
                            <i class="fa-solid fa-square-root-variable" style="color: var(--text-primary);"></i>
                            <p><?= $afficherUneAnnonce['surface'] ?> m²</p>
                        </div>
                        <div class="details">
                            <i class="fa-solid fa-bath" style="color: var(--text-primary);"></i>
                            <p><?= $afficherUneAnnonce['nombre_chambre'] ?> bed</p>
                        </div>
                        <div class="details reverse">
                            <i class="fa-solid fa-bed" style="color: var(--text-primary);"></i>
                            <p><?= $afficherUneAnnonce['nombre_salle_bain'] ?> bath</p>
                        </div>
                    </div>
                    <div class="box-button">
                        <a href="<?= RACINE_SITE ?>adverts.php" class="bouton-primary">Retourner sur toutes les annonces</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="description-property">
            <h3>Description de l'annonce</h3>
            <p><?= $afficherUneAnnonce['description'] ?></p>
            <?php if($afficherUneAnnonce['reservation_message'] != NULL) : ?>
                <div class="reservation-message">
                    <h3>Message de réservation</h3>
                    <p><?= $afficherUneAnnonce['reservation_message'] ?></p>
                    <?= '<div class="alert-success">Annonce Déjà Réservée</div>' ?>
                </div>
            <?php else : ?>
            <h3>Message de réservation</h3>
            <form action="" method="post">
                <textarea name="reservation_message" id="reservation_message" cols="30" rows="10" placeholder="Laissez un message pour réserver cette annonce"></textarea>
                <button type="submit" class="bouton-primary">Réserver</button>
            </form>
            <?php endif; ?>
            <a href="<?= RACINE_SITE ?>index.php" class="bouton-primary">Revenir sur la page d'accueil</a>
        </div>
    </div>
</section>

<?php
require_once("inc/footer.inc.php");
?>
<?php
require_once("inc/footer.inc.php");
?>