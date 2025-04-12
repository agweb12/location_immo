
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

$annonces12 = afficherDouzeAnnonces();
$annonces = afficherToutesLesAnnonces();
$typeImmobiliers = afficherTousLesTypesImmobilier();
$derniere9ImagesAnnonces = afficherDernieres6ImagesAnnonces();
$types = afficherTousLesTypesAnnonces();

require_once("inc/header.inc.php");
?>
<section class="presentation" id="presentation">
    <div class="row-box">
        <div class="text-box">
            <h1>Trouve<span> ton bien </span>pour vivre avec ta famille</h1>
            <p>Location Immo te propose des biens pour toi et ta famille en fonction de ton budget et de ton profil familial</p>
            <a href="#advertList" class="bouton-primary">Get Started</a>
        </div>
        <hr>
        <div class="img-box">
        </div>
    </div>
</section>
<section class="banner">
    <form class="banner" action="" method="post">
        <select name="type_immobilier" id="type_immobilier">
            <option selected>Type d'Immobilier</option>
            <?php foreach($typeImmobiliers as $typeImmo): ?>
                <option value="<?= $typeImmo['type_immobilier'] ?>"><?= ucfirst($typeImmo['type_immobilier']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="type" id="type">
            <option selected>Type</option>
            <?php foreach($types as $type): ?>
                <option value="<?= $type['type'] ?>"><?= ucfirst($type['type']) ?></option>
            <?php endforeach; ?>
        </select>
        <?php 
            // Je vérifie si le formulaire a été soumis
            if(isset($_POST['type_immobilier']) && isset($_POST['type'])) {
                // Je récupère les valeurs du formulaire
                $typeImmo = $_POST['type_immobilier'];
                $type = $_POST['type'];
                // Je redirige vers la page des annonces avec les paramètres de recherche
                header("Location: adverts.php?typeImmo=$typeImmo&type=$type");
            }
            // // Je vérifie si les paramètres de recherche sont présents dans l'URL
            // if(isset($_GET['typeImmo']) && isset($_GET['type'])) {
            //     // Je récupère les valeurs des paramètres de recherche
            //     $typeImmo = $_GET['typeImmo'];
            //     $type = $_GET['type'];
            //     // Je redirige vers la page des annonces avec les paramètres de recherche
            //     header("Location: adverts.php?typeImmo=$typeImmo&type=$type");
            // }
        
        ?>
        <button class="bouton-secondary" type="submit">Rechercher</button>
        <!-- <a href="adverts.php?typeImmo=&type=" class="bouton-secondary">Rechercher</a> -->
    </form>
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
<section class="place">
    <div class="img-place">
        <div class="shape"></div>
        <img src="assets/img/about.jpg" alt="à propos de location immo">
    </div>
    <div class="place-box">
        <h2>#1 place to find the perfect property</h2>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis dolorem laudantium fuga quis saepe
            inventore voluptatum velit quia delectus vero quod, a consectetur unde vitae. Vitae ad illum eius
            quia.</p>
        <ul>
            <li>
                <i class="fa-solid fa-check" style="color: var(--text-primary)"></i>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            <li>
                <i class="fa-solid fa-check" style="color: var(--text-primary)"></i>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </li>
            <li>
                <i class="fa-solid fa-check" style="color: var(--text-primary)"></i>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </li>
        </ul>
        <a href="" class="bouton-primary">read more</a>
    </div>
</section>
<section class="listingproperty" id="advertList">
    <div class="list-box">
        <div class="title-box">
            <h2>Les 12 dernières annonces</h2>
            <p>Nous sommes heureux de vous présenter nos 12 dernières annonces pour votre famille</p>
        </div>
    </div>
    <div class="listproperty-box">
        <?php foreach($annonces12 as $annonce): ?>
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
    <a href="<?= RACINE_SITE ?>adverts.php" class="bouton-primary">Parcourir toutes les annonces</a>
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
<section class="agents">
    <h2>Property Agents</h2>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam error facere itaque pariatur perferendis
        fugit enim rerum illo, excepturi dolores illum recusandae odio amet necessitatibus, perspiciatis eos
        deleniti voluptas. Dolore.</p>
    <div class="agents-container">
        <div class="agents-box">
            <img src="assets/img/team-1.jpg" alt="">
            <div class="socialmedia">
                <a href=""><i class="fa-brands fa-facebook-f" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-linkedin-in" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-tiktok" style="color: var(--text-primary);"></i></a>
            </div>
            <div class="details-box">
                <h3>Maria Doe</h3>
                <p>Property Agent</p>
            </div>
        </div>
        <div class="agents-box">
            <img src="assets/img/team-2.jpg" alt="">
            <div class="socialmedia">
                <a href=""><i class="fa-brands fa-facebook-f" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-linkedin-in" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-tiktok" style="color: var(--text-primary);"></i></a>
            </div>
            <div class="details-box">
                <h3>John Doe</h3>
                <p>Property Agent</p>
            </div>
        </div>
        <div class="agents-box">
            <img src="assets/img/team-3.jpg" alt="">
            <div class="socialmedia">
                <a href=""><i class="fa-brands fa-facebook-f" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-linkedin-in" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-tiktok" style="color: var(--text-primary);"></i></a>
            </div>
            <div class="details-box">
                <h3>Jane Doe</h3>
                <p>Property Agent</p>
            </div>
        </div>
        <div class="agents-box">
            <img src="assets/img/team-4.jpg" alt="">
            <div class="socialmedia">
                <a href=""><i class="fa-brands fa-facebook-f" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-linkedin-in" style="color: var(--text-primary);"></i></a>
                <a href=""><i class="fa-brands fa-tiktok" style="color: var(--text-primary);"></i></a>
            </div>
            <div class="details-box">
                <h3>Brown Doe</h3>
                <p>Property Agent</p>
            </div>
        </div>
    </div>
</section>
<section class="testimony">
    <h2>our clients say !</h2>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti quasi a repudiandae aspernatur unde,
        id similique provident, laudantium autem incidunt placeat officia consequuntur culpa, fuga sed? Iste
        blanditiis iusto aliquid!</p>
    <div class="testimony-box">
        <div class="testimony-card">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex ducimus accusantium amet facere,
                similique quo odit porro omnis reiciendis alias?</p>
            <div class="details-testimony">
                <img src="assets/img/testimonial-1.jpg" alt="">
                <div class="box-row-test">
                    <h3>Client Name</h3>
                    <p>Profession</p>
                </div>
            </div>
        </div>
        <div class="testimony-card">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex ducimus accusantium amet facere,
                similique quo odit porro omnis reiciendis alias?</p>
            <div class="details-testimony">
                <img src="assets/img/testimonial-2.jpg" alt="">
                <div class="box-row-test">
                    <h3>Client Name</h3>
                    <p>Profession</p>
                </div>
            </div>
        </div>
        <div class="testimony-card">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex ducimus accusantium amet facere,
                similique quo odit porro omnis reiciendis alias?</p>
            <div class="details-testimony">
                <img src="assets/img/testimonial-3.jpg" alt="">
                <div class="box-row-test">
                    <h3>Client Name</h3>
                    <p>Profession</p>
                </div>
            </div>
        </div>
        <div class="testimony-card">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex ducimus accusantium amet facere,
                similique quo odit porro omnis reiciendis alias?</p>
            <div class="details-testimony">
                <img src="assets/img/testimonial-4.jpg" alt="">
                <div class="box-row-test">
                    <h3>Client Name</h3>
                    <p>Profession</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once("inc/footer.inc.php");
?>