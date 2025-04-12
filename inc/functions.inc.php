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

#### Création de la base de données
#### ETAPE 1
function creationBaseDeDonnees(): void
{
    $pdo = connexionBDD();
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NOM;
    $pdo->exec($sql);
}
// creationBaseDeDonnees(); // Décommenter pour créer la base de données lors du chargement de la page

#### ETAPE 2
#### Création de la table advert
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
// creationTableAdvert(); // Décommenter pour créer la table lors du chargement de la page

#### ETAPE 3
#### Fonction d'insertion de 20 annonces avec 17 réservations = NULL
function insertionAnnonces(): void
{
    $pdo = connexionBDD();
    $sql = "INSERT INTO advert (photo, title, description, postal_code, city, type, price, reservation_message, type_immobilier, surface, nombre_chambre, nombre_salle_bain) 
            VALUES 
            ('photo1.jpg', 'Titre 1', ' 1', '75001', 'Paris', 'location', 1000.00, NULL, 'appartement', 50.00, 2, 1),
            ('photo2.jpg', 'Titre 2', ' 2', '75002', 'Paris', 'vente', 200000.00, NULL, 'maison', 100.00, 3, 2),
            ('photo3.jpg', 'Titre 3', ' 3', '75003', 'Paris', 'location', 1500.00, NULL, 'terrain', 200.00, 4, 3),
            ('photo4.jpg', 'Titre 4', ' 4', '75004', 'Paris', 'vente', 250000.00, NULL, 'appartement', 75.00, 2, 1),
            ('photo5.jpg', 'Titre 5', ' 5', '75005', 'Paris', 'location', 1200.00, NULL, 'maison', 80.00, 3, 2),
            ('photo6.jpg', 'Titre 6', ' 6', '75006', 'Paris', 'vente', 300000.00, NULL, 'terrain', 150.00, 4, 3),
            ('photo7.jpg', 'Titre 7', ' 7', '75007', 'Paris', 'location', 1300.00, NULL, 'appartement', 60.00, 2, 1),
            ('photo8.jpg', 'Titre 8', ' 8', '75008', 'Paris', 'vente', 350000.00, NULL, 'maison', 90.00, 3, 2),
            ('photo9.jpg', 'Titre 9', ' 9', '75009', 'Paris','location' ,1400.00 ,NULL ,'terrain' ,170.00 ,4 ,3),
            ('photo10.jpg', 'Titre 10', ' 10', '75010', 'Paris', 'vente', 400000.00, NULL, 'appartement', 85.00, 2, 1),
            ('photo11.jpg', 'Titre 11', ' 11', '75011', 'Paris', 'location', 1100.00, NULL, 'maison', 95.00, 3, 2),
            ('photo12.jpg', 'Titre 12', ' 12', '75012', 'Paris', 'vente', 450000.00, NULL, 'terrain', 160.00, 4, 3),
            ('photo13.jpg', 'Titre 13', ' 13', '75013', 'Paris','location' ,1150.00 ,NULL ,'appartement' ,70.00 ,2 ,1),
            ('photo14.jpg', 'Titre 14', ' 14', '75014', 'Paris','vente' ,500000.00 ,NULL ,'maison' ,110.00 ,3 ,2),
            ('photo15.jpg', 'Titre 15', ' 15', '75015', 'Paris','location' ,1250.00 ,NULL ,'terrain' ,180.00 ,4 ,3),
            ('photo16.jpg', 'Titre 16', ' 16', '75016','Paris' ,'vente' ,550000.00 ,NULL ,'appartement' ,90.00 ,2 ,1),
            ('photo17.jpg', 'Titre 17', ' 17','75017' ,'Paris' ,'location' ,1350.00 ,NULL ,'maison' ,100.00 ,3 ,2),
            ('photo18.jpg','Titre 18',' 18','75018','Paris','vente' ,600000.00,NULL,'terrain' ,190.00,4,3),
            ('photo19.jpg','Titre 19',' 19','75019','Paris','location' ,1450.00,NULL,'appartement' ,80.00,2,1),
            ('photo20.jpg','Titre 20',' 20','75020','Paris','vente' ,650000.00,NULL,'maison' ,120.00,3,2)";
    $pdo->exec($sql);
}
// insertionAnnonces(); // Décommenter pour insérer les annonces lors du chargement de la page

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