<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);


define('DB_HOTE', 'localhost');
define('DB_UTILISATEUR', 'root');
define('DB_MOTDEPASSE', '');
define('DB_NOM', 'evaluation_php_graziani');

define("RACINE_SITE", "http://localhost/evaluation_PHP_graziani/");


#### Création d'une fonction alerte
// fa-xmark pour danger
// fa-check pour succès
// fa-triangle-exclamation pour avertissement
function alert(string $message, string $type = "danger", string $icon = "fa-xmark"): string
{
    return "<div class='alert-$type' role='alert'>
            <i class='fa-solid $icon'></i>
            <p class='alert'>$message</p>
        </div>";
}

#### Fonction pour debuger
function debug($var): void
{
    echo "<pre class='alert-warning' role='alert'>";
    var_dump($var);
    echo "</pre>";
}

function connexionBDD(): object
{
    $dsn = "mysql:host=" . DB_HOTE . ";dbname=" . DB_NOM . ";charset=utf8";

    try {
        $pdo = new PDO($dsn, DB_UTILISATEUR, DB_MOTDEPASSE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
    return $pdo;
}

function creationTableAdvert(): void{
    $pdo = connexionBDD();
    $sql = "CREATE TABLE IF NOT EXISTS advert (
        id_advert INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        photo VARCHAR(255) NOT NULL,
        title VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        postal_code VARCHAR(10) NOT NULL,
        city VARCHAR(50) NOT NULL,
        type ENUM('location', 'vente') NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        reservation_message TEXT NULL,
        type_immobilier ENUM('appartement', 'maison', 'terrain') NOT NULL,
        surface DECIMAL(10,2) NOT NULL,
        nombre_chambre INT NOT NULL,
        nombre_salle_bain INT NOT NULL
        )";
    $pdo->exec($sql);
}
// creationTableAdvert();

// Ajouter une annonce
function ajouterUneAnnonce(string $photo, string $titre, string $description, string $code_postal, string $ville, string $type, float $prix, $reservation_message ,string $type_immobilier, int $surface, int $nombre_chambre, int $nombre_salle_bain): void{

    $data = [
        'photo' => $photo,
        'title' => $titre,
        'description' => $description,
        'postal_code' => $code_postal,
        'city' => $ville,
        'type' => $type,
        'price' => $prix,
        'reservation_message' => null,
        'type_immobilier' => $type_immobilier,
        'surface' => $surface,
        'nombre_chambre' => $nombre_chambre,
        'nombre_salle_bain' => $nombre_salle_bain
    ];

    $pdo = connexionBDD();
    $sql = "INSERT INTO advert (photo, title, description, postal_code, city, type, price, reservation_message, type_immobilier, surface, nombre_chambre, nombre_salle_bain) 
            VALUES (:photo, :title, :description, :postal_code, :city, :type, :price, :reservation_message, :type_immobilier, :surface, :nombre_chambre, :nombre_salle_bain)";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(
        ":photo" => $data['photo'],
        ":title" => $data['title'],
        ":description" => $data['description'],
        ":postal_code" => $data['postal_code'],
        ":city" => $data['city'],
        ":type" => $data['type'],
        ":price" => $data['price'],
        ":reservation_message" => $data['reservation_message'],
        ":type_immobilier" => $data['type_immobilier'],
        ":surface" => $data['surface'],
        ":nombre_chambre" => $data['nombre_chambre'],
        ":nombre_salle_bain" => $data['nombre_salle_bain']
    ));
}

// Afficher une annonce en rapport à son titre
function afficherUneAnnonce(string $id): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert WHERE id_advert = :id";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(':id' => $id));
    $resultat = $requete->fetch();
    return $resultat;
}

#### vérifier si l'annonce existe déjà
function annonceExisteDeja(string $titre): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT title FROM advert WHERE title = :title";
    $requete = $pdo->prepare($sql);
    $requete->bindValue(':title', $titre);
    $requete->execute();
    $resultat = $requete->fetch();
    return $resultat;
}


#### Afficher toutes les annonces
function afficherToutesLesAnnonces(): mixed // $categories
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert ORDER BY title DESC";
    $requete = $pdo->query($sql);
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher 15 annonces à partir de la dernière (annonce la plus récente)
function afficherDouzeAnnonces(): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert ORDER BY id_advert DESC LIMIT 12";
    $requete = $pdo->query($sql);
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher tous les types d'immobilier
function afficherTousLesTypesImmobilier(): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT DISTINCT type_immobilier FROM advert";
    $requete = $pdo->query($sql);
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher tous les types d'annonces
function afficherTousLesTypesAnnonces(): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT DISTINCT type FROM advert";
    $requete = $pdo->query($sql);
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher le nombre d'annonce par type immobilier
function nombreAnnoncesParTypeImmobilier(string $type_immobilier): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT COUNT(*) AS nombre FROM advert WHERE type_immobilier = :type_immobilier";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(':type_immobilier' => $type_immobilier));
    $resultat = $requete->fetch();
    return $resultat;
}

#### Afficher le nombre d'annonce par type
function nombreAnnoncesParType(string $type): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT COUNT(*) AS nombre FROM advert WHERE type = :type";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(':type' => $type));
    $resultat = $requete->fetch();
    return $resultat;
}

#### Afficher les 6 dernières images d'annonces
function afficherDernieres6ImagesAnnonces(): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT photo FROM advert ORDER BY id_advert DESC LIMIT 6";
    $requete = $pdo->query($sql);
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher les annonces par type d'immobilier et par type de vente
function afficherAnnoncesParTypeImmoEtTypeVente(string $type_immobilier, string $type): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert WHERE type_immobilier = :type_immobilier AND type = :type";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(
        ':type_immobilier' => $type_immobilier,
        ':type' => $type
    ));
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher les annonces par type
function afficherAnnoncesParTypeVente(string $type): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert WHERE type = :type";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(':type' => $type));
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Afficher les annonces par type d'immobilier
function afficherAnnoncesParTypeImmobilier(string $type_immobilier): mixed
{
    $pdo = connexionBDD();
    $sql = "SELECT * FROM advert WHERE type_immobilier = :type_immobilier";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(':type_immobilier' => $type_immobilier));
    $resultat = $requete->fetchAll();
    return $resultat;
}

#### Supprimer une annonce
function supprimerUneAnnonce(string $titre): void
{
    $pdo = connexionBDD();
    $sql = "DELETE FROM advert WHERE title = :title";
    $requete = $pdo->prepare($sql);
    $requete->execute(array(
        ":title" => $titre
    ));
}