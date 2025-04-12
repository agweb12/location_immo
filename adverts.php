<?php
require_once("inc/functions.inc.php");
$h1 = "Accueil - Location Immo";
$description = "Location Immo - Trouvez la maison parfaite pour votre famille !";
$bootstrapHeader = "";
$scriptJS = '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="<?= RACINE_SITE ?>assets/js/script.js"></script>';
$bootstrapFooter = "";
$alerte = "";
$typeImmobiliers = afficherTousLesTypesImmobilier();
$derniere9ImagesAnnonces = afficherDernieres6ImagesAnnonces();

// Traitement des paramètres GET dans l'URL pour afficher des annonces en rapport au type d'immobilier et leur type
if (isset($_GET['typeImmo']) && isset($_GET['type'])) {
    $type_immobilier = htmlspecialchars($_GET['typeImmo']);
    $type = htmlspecialchars($_GET['type']);
    $toutesLesAnnonces = afficherAnnoncesParTypeImmoEtTypeVente($type_immobilier, $type);
    $h2 = count($toutesLesAnnonces) . " Annonces en " . ucfirst($type) . " de type " . ucfirst($type_immobilier);
} elseif (isset($_GET['typeImmo'])) {
    $type_immobilier = htmlspecialchars($_GET['typeImmo']);
    $toutesLesAnnonces = afficherAnnoncesParTypeImmobilier($type_immobilier);
    $h2 = count($toutesLesAnnonces) . " Annonces de type " . ucfirst($type_immobilier);
} elseif (isset($_GET['type'])) {
    $type = htmlspecialchars($_GET['type']);
    $toutesLesAnnonces = afficherAnnoncesParTypeVente($type);
    $h2 = count($toutesLesAnnonces) . " Annonces en " . ucfirst($type);
} else{
    $toutesLesAnnonces = afficherToutesLesAnnonces();
}

require_once("inc/header.inc.php");
?>
<section class="listingproperty" id="advertList">
    <div class="list-box">
        <div class="title-box">
            <h2>
                <?php if (isset($h2)) {
                    echo $h2;
                } else {
                    echo "Annonces de toutes les catégories";
                } ?>
            </h2>
            <p>Nous sommes heureux de vous présenter toutes nos annonces pour votre famille</p>
        </div>
        <div class="button-box">
            <button class="bouton-outline">Toutes les annonces</button>
            <button class="bouton-outline" onclick="">Déjà Réservée</button>
            <button class="bouton-outline">En Vente</button>
            <button class="bouton-outline">À Louer</button>
        </div>
    </div>
    <div class="listproperty-box">
    <?php
        if (count($toutesLesAnnonces) == 0) {
            echo '<h3>Aucune annonce trouvée</h3>';
        }
    ?>
    <?php foreach($toutesLesAnnonces as $annonce): ?>
        <div class="property-box">
            <a href="<?= RACINE_SITE ?>Oneadvert.php?id=<?= $annonce['id_advert'] ?>">
                <img src="<?= RACINE_SITE ?>assets/img/<?= $annonce['photo']?>" alt="image de l'annonce <?= $annonce['id_advert']?>">
            </a>
            <?php if($annonce['reservation_message'] != NULL): ?>
                <?php if($annonce['type'] == "vente"): ?>
                    <h4 style="background-color:#999"><?= ucfirst('Déjà Vendu')?></h4>
                <?php elseif($annonce['type'] == "location"): ?>
                    <h4 style="background-color:#999"><?= ucfirst('Déjà Loué')?></h4>
                <?php endif; ?>
            <?php else: ?>
                <h4>En <?= ucfirst($annonce['type']) ?></h4>
            <?php endif; ?>
            <h5><?= ucfirst($annonce['type_immobilier']) ?></h5>
            <div class="box-details-property">
                <div class="details-property">
                    <h6 class="price"><?= $annonce['price'] ?> €</h6>
                    <h3><?= strtoupper($annonce['title']) ?> en <?= $annonce['type'] ?></h3>
                    <div class="location">
                        <i class="fa-solid fa-location-pin" style="color: var(--text-primary);"></i>
                        <p><?= $annonce['postal_code'] ?>, <?= $annonce['city'] ?></p>
                    </div>
                </div>
                <div class="row-details">
                    <div class="details">
                        <i class="fa-solid fa-square-root-variable" style="color: var(--text-primary);"></i>
                        <p><?= $annonce['surface'] ?> m²</p>
                    </div>
                    <div class="details">
                        <i class="fa-solid fa-bath" style="color: var(--text-primary);"></i>
                        <p><?= $annonce['nombre_chambre'] ?> bed</p>
                    </div>
                    <div class="details reverse">
                        <i class="fa-solid fa-bed" style="color: var(--text-primary);"></i>
                        <p><?= $annonce['nombre_salle_bain'] ?> bath</p>
                    </div>
                </div>
                <div class="box-button">
                    <?php if($annonce['reservation_message'] != NULL): ?>
                        <a href="<?= RACINE_SITE ?>oneAdvert.php?id=<?= $annonce['id_advert'] ?>" class="bouton-primary disabled">Déjà Réservée</a>
                    <?php else: ?>
                        <a href="<?= RACINE_SITE ?>oneAdvert.php?id=<?= $annonce['id_advert'] ?>" class="bouton-primary">Consulter une annonce</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="<?= RACINE_SITE ?>index.php" class="bouton-primary">Revenir sur la page d'accueil</a>
</section>
<section class="property" id="">
    <h2>types de propriétés</h2>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Natus aliquam qui consequatur cum architecto
        nihil non pariatur deserunt dolor praesentium porro fugiat aspernatur saepe ut itaque fuga enim,
        delectus, rerum dicta. Molestias pariatur ex repellendus excepturi libero ipsam. Expedita fugit sunt,
        repellat quia consequuntur necessitatibus libero facere fuga iste maxime?</p>
    <div class="box">
    <?php 
            // Je parcours le tableau associatif $typeImmobiliers pour afficher chaque type d'immobilier
            foreach($typeImmobiliers as $typeImmo): 
        ?>
        <div class="square-box">
            <div class="img-box">
                <?php if($typeImmo['type_immobilier'] == "appartement"): ?>
                    <img src="assets/img/icon-apartment.png" alt="icone appartement">
                <?php elseif($typeImmo['type_immobilier'] == "maison"): ?>
                    <img src="assets/img/icon-house.png" alt="icone maison">
                <?php elseif($typeImmo['type_immobilier'] == "terrain"): ?>
                    <img src="assets/img/icon-deal.png" alt="icon terrain">
                <?php endif; ?>
            </div>
            <div class="rectangle-box">
                <h3><?= strtoupper($typeImmo['type_immobilier']) ?></h3>
                <?php
                    // J'affiche le nombre d'annonces par type d'immobilier avec la fonction nombreAnnoncesParType
                    // Je récupère la valeur du type d'immobilier dans le tableau associatif $typeImmo
                    $nombreAnnonces = nombreAnnoncesParTypeImmobilier($typeImmo['type_immobilier']); 
                    // Je convertis le tableau associatif en chaine de caractères
                    $nombreAnnonces = implode($nombreAnnonces);
                ?>
                <p><?= ucfirst($nombreAnnonces ." annonces") ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<section class="contact">
    <div class="image">
        <img src="assets/img/call-to-action.jpg" alt="">
    </div>
    <div class="contact-box">
        <h2>Contact with our certified agent</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum itaque, quibusdam illum sint similique
            tenetur.</p>
        <div class="button-box">
            <a href="" class="bouton-primary"><i class="fa-solid fa-phone" style="color: var(--text-white)"></i>
                Make a Call</a>
            <a href="" class="bouton-secondary"><i class="fa-solid fa-calendar-days"
                    style="color: var(--text-white)"></i> Get Appoinment</a>
        </div>
    </div>
</section>

<?php
require_once("inc/footer.inc.php");
?>
<?php
require_once("inc/footer.inc.php");
?>