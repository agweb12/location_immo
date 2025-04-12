<?php
require_once("inc/functions.inc.php");
$h1 = "Ajouter une annonce - Location Immo";
$description = "Contactez-nous pour toute question ou demande d'information sur nos services de location immobilière.";
$bootstrapHeader = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">';
$scriptJS = '';
$bootstrapFooter = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>';
$derniere9ImagesAnnonces = afficherDernieres6ImagesAnnonces();

// Déclaration de la variable d'alerte dans le cas d'erreur, de succès ou d'information
$alerte = "";

#### Traitement du formulaire d'ajout d'une annonce

// Je vérifie si l'utilisateur a cliqué sur le bouton "Ajouter une annonce"

if(!empty($_POST)){
    // Je crée une variable de vérification en tant que booléen
    $verification = true;

    // Je boucle sur chaque champs du formulaire pour vérifier si ils sont vides ou non au moment de la soumission
    foreach($_POST as $key => $value){
        if(empty($value)){
            $verification = false;
        }
    }

    // Je vérifie chaque champs dans le cas où la vérification est fausse
    // C'est à dire si l'utilisateur n'a pas rempli tous les champs
    if($verification === false){
        $alerte = alert("Veuillez remplir tous les champs du formulaire", "danger", "fa-xmark");
    } else {
        // Je vérifie chaque champs du formulaire

        #### VERIFICATION DE LA PHOTO ####

        // Je stocke les informations de la photo
        $fichierPhoto = $_FILES['photo'];
        // Je récupère l'extension de la photo
        $extension = pathinfo($fichierPhoto['name'], PATHINFO_EXTENSION); 
        // Je vérifie si l'extension de la photo est autorisée
        $extension_autorisees = ['jpg', 'png', 'gif'];

        // Je vérifie l'existence de la photo avec un switch pour gérer chaque cas d'erreurs
        if($fichierPhoto['error'] != 0) {
            switch($fichierPhoto['error']) {
                // Je vérifie le cas où la photo est trop grande
                case UPLOAD_ERR_INI_SIZE:
                    $alerte .= alert("La taille de la photo est trop grande", "danger", "fa-xmark");
                    break;
                // Je vérifie le cas où la photo n'a pas été entièrement téléchargée
                case UPLOAD_ERR_PARTIAL:
                    $alerte .= alert("La photo n'a pas été entièrement téléchargée", "danger", "fa-xmark");
                    break;
                // Je vérifie le cas où la photo n'a pas été téléchargée
                case UPLOAD_ERR_NO_FILE:
                    $alerte .= alert("Aucune photo n'a été téléchargée", "danger", "fa-xmark");
                    break;
                default: 
                    $alerte .= alert("Une erreur inconnue s'est produite lors du téléchargement de la photo", "danger", "fa-xmark");
                    break;
            }
        } elseif(!in_array($extension, $extension_autorisees)){ // Je vérifie si l'extension de la photo est autorisée
            $alerte .= alert("L'extension de la photo n'est pas autorisée. Veuillez choisir une image png, jpg ou gif", "danger", "fa-xmark");
        } elseif($fichierPhoto['size'] > 2000000){ // Je vérifie si la taille de la photo est inférieure à 2 Mo
            $alerte .= alert("L'image doit faire moins de 2 Mo", "warning", "fa-triangle-exclamation");
        } elseif($fichierPhoto['error'] == 0){ 
            // Je déplace la photo dans le dossier img des annonces
            $chemin = "assets/img/" . $fichierPhoto['name'];
            move_uploaded_file($fichierPhoto['tmp_name'], $chemin);

            $photo = $fichierPhoto['name'];
        } else{
            $alerte .= alert("Une erreur s'est produite lors du téléchargement de la photo", "danger", "fa-xmark");
        }

        #### VERIFICATION DU TITRE ####
        // Je vérifie si le titre s'il est d'une longueur minimal de 5 caractères, qu'il ne contient pas de caractères spéciaux
       $regexTitre = "/^[a-zA-Z0-9\s]+$/";

        if(strlen($_POST['title']) < 5 || strlen($_POST['title']) > 50 || !preg_match($regexTitre, $_POST['title'])){
            $alerte .= alert("Le titre doit faire entre 5 et 50 caractères et ne doit pas contenir de caractères spéciaux", "danger", "fa-xmark"); 
        }

        #### VERIFICATION DE LA DESCRIPTION ####
        // Je vérifie si la description s'il est d'une longueur minimal de 20 caractères, peut contenir des chiffres et des caractères spéciaux
        if(strlen($_POST['description']) < 20 || strlen($_POST['description']) > 500){
            $alerte .= alert("La description doit faire entre 20 et 500 caractères", "danger", "fa-xmark");
        }

        #### VERIFICATION DU CODE POSTAL ####
        // Je vérifie si le code postal est valide, c'est à dire qu'il doit faire 5 chiffres
        $regexCodePostal = "/^[0-9]{5}$/";
        if(!preg_match($regexCodePostal, $_POST['postal_code'])){
            $alerte .= alert("Le code postal doit faire 5 chiffres", "danger", "fa-xmark");
        }

        #### VERIFICATION DE LA VILLE ####
        // Je vérifie si la ville est d'une longueur minimal de 2 caractères et qu'elle ne contient pas de chiffres. Elle peut contenir des caractères spéciaux
        $regexVille = "/^[a-zA-Z\s\-]+$/";
        // Je vérifie si la ville est d'une longueur minimal de 2 caractères et qu'elle ne contient pas de chiffres
        // Elle peut contenir des caractères spéciaux
        
        if(strlen($_POST['city']) < 2 || strlen($_POST['city']) > 50 || !preg_match($regexVille, $_POST['city'])){
            $alerte .= alert("La ville doit faire entre 2 et 50 caractères et ne doit pas contenir de chiffres", "danger", "fa-xmark");
        }
        
        #### VERIFICATION DU TYPE ####
        // Je vérifie si le type est valide, c'est à dire qu'il doit être soit "location" soit "vente"
        if($_POST['type'] != "location" && $_POST['type'] != "vente"){
            $alerte .= alert("Le type doit être soit 'location' soit 'vente'", "warning", "fa-triangle-exclamation");
        }

        #### VERIFICATION DU TYPE IMMOBILIER ####
        // Je vérifie si le type immobilier est valide, c'est à dire qu'il doit être soit "appartement" soit "maison" soit "terrain"
        if($_POST['type_immobilier'] != "appartement" && $_POST['type_immobilier'] != "maison" && $_POST['type_immobilier'] != "terrain"){
            $alerte .= alert("Le type immobilier doit être soit 'appartement' soit 'maison' soit 'terrain'", "warning", "fa-triangle-exclamation");
        }

        #### VERIFICATION DE LA SURFACE ####
        // Je vérifie si la surface est un nombre décimal positif et qu'il n'est pas vide
        $regexSurface = "/^[0-9]+(\.[0-9]{1,2})?$/";
        if(!preg_match($regexSurface, $_POST['surface']) || $_POST['surface'] <= 0){
            $alerte .= alert("La surface doit être un nombre positif", "warning", "fa-triangle-exclamation");
        }


        #### VERIFICATION DU NOMBRE DE CHAMBRES ####
        // Je vérifie si le nombre de chambres est un entier positif et qu'il n'est pas vide
        $regexNombreChambre = "/^[0-9]+$/";
        if(!preg_match($regexNombreChambre, $_POST['nombre_chambre']) || $_POST['nombre_chambre'] < 0){
            $alerte .= alert("Le nombre de chambres doit être un entier positif", "warning", "fa-triangle-exclamation");
        }


        #### VERIFICATION DU NOMBRE DE SALLES DE BAIN ####
        // Je vérifie si le nombre de salles de bain est un entier positif et qu'il n'est pas vide
        $regexNombreSalleBain = "/^[0-9]+$/";
        if(!preg_match($regexNombreSalleBain, $_POST['nombre_salle_bain']) || $_POST['nombre_salle_bain'] < 0){
            $alerte .= alert("Le nombre de salles de bain doit être un entier positif", "warning", "fa-triangle-exclamation");
        }

        #### VERIFICATION DU PRIX ####
        // Je vérifie si le prix est un nombre décimal positif et qu'il n'est pas vide
        $regexPrix = "/^[0-9]+(\.[0-9]{1,2})?$/";
        if(!preg_match($regexPrix, $_POST['price']) || $_POST['price'] <= 0){
            $alerte .= alert("Le prix doit être un nombre positif", "warning", "fa-triangle-exclamation");
        }

        // Je vérifie si l'alerte est vide, c'est à dire qu'il n'y a pas d'erreurs
        if(empty($alerte)){
            $photo = str_replace(" ", "_", $photo);
            $photo = str_replace("'", "_", $photo);
            $photo = str_replace("(", "_", $photo);
            $photo = str_replace(")", "_", $photo);
            
            $photo = htmlspecialchars(trim($photo));
            $titre = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $code_postal = htmlspecialchars(trim($_POST['postal_code']));
            $ville = htmlspecialchars(trim($_POST['city']));
            $type = htmlspecialchars(trim($_POST['type']));
            $price = htmlspecialchars(trim($_POST['price']));
            $reservation_message = null;
            $type_immobilier = htmlspecialchars(trim($_POST['type_immobilier']));
            $surface = htmlspecialchars(trim($_POST['surface']));
            $nombre_chambre = htmlspecialchars(trim($_POST['nombre_chambre']));
            $nombre_salle_bain = htmlspecialchars(trim($_POST['nombre_salle_bain']));

            $annonceExisteDeja = annonceExisteDeja($titre);
            // Je vérifie si l'annonce existe déjà

            if($annonceExisteDeja){
                $alerte .= alert("Cette annonce existe déjà", "warning", "fa-triangle-exclamation");
            } else {
                // J'appelle la fonction d'ajout d'une annonce
                ajouterUneAnnonce($photo, $titre, $description, $code_postal, $ville, $type, $price, $reservation_message, $type_immobilier, $surface, $nombre_chambre, $nombre_salle_bain);
                // J'affiche un message de succès
                $alerte .= alert("L'annonce a été ajoutée avec succès", "success", "fa-check");
                // Je redirige l'utilisateur vers la page d'accueil après 3 secondes
                header("refresh: 3; url=" . RACINE_SITE . "adverts.php");
            }
        }
    }
}


require_once("inc/header.inc.php");
?>
 <h1><?= strtoupper("Ajouter une annonce");?></h1>
        <?= $alerte ?>
    <form action="" method="post" enctype="multipart/form-data" class="w-75 p-5 m-3 rounded-3" style="background-color:var(--bg-opacity)">
        <div class="row">
            <div class="row-md-6 mb-2">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control">
            </div>
            <div class="col-md-6 mb-2">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" style="--bs-focus-ring-color: rgba(var(--bs-success-rgb), .25)" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-2">
                <label for="description" >Description</label>
                <textarea name="description" id="description" cols="10" rows="5" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <label for="postal_code">Code Postal</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="" placeholder="">
            </div>
            <div class="col-md-6">
                <label for="city">Ville</label>
                <input type="text" class="form-control" id="city" name="city" value="" placeholder="">
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-select form-select-lg" name="type" id="type">
                    <option selected>Type</option>
                    <option value="location">En Location</option>
                    <option value="vente">En Vente</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="type_immobilier" class="form-label">Type Immobilier</label>
                <select class="form-select form-select-lg" name="type_immobilier" id="type_immobilier">
                    <option selected>Type immobilier</option>
                    <option value="appartement">Appartement</option>
                    <option value="maison">Maison</option>
                    <option value="terrain">Terrain</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="surface">Surface</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="surface" name="surface" aria-label="Mètres carrés habitable" value="" >
                    <span class="input-group-text">m² habitable</span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="nombre_chambre">Nombre de Chambre</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="nombre_chambre" name="nombre_chambre" value="" >
                </div>
            </div>
            <div class="col-md-3">
                <label for="nombre_salle_bain">Nombre de Salle de Bain</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="nombre_salle_bain" name="nombre_salle_bain" value="" >
                </div>
            </div>
            <div class="col-md-6">
                <label for="price">Prix</label>
                <div class=" input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros" value="" >
                    <span class="input-group-text">€</span>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <button type="submit" class="bouton-primary w-100 position-relative" style="z-index: 5;">Ajouter une annonce</button>
            </div>
        </div>
        <!-- <button type="submit" class="bouton-primary">Ajouter une annonce</button> -->
        
    </form>
<?php
require_once("inc/footer.inc.php");
?>