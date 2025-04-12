<?php
require_once("inc/functions.inc.php");
$h1 = "Contact - Location Immo";
$description = "Contactez-nous pour toute question ou demande d'information sur nos services de location immobilière.";
$bootstrapHeader = "";
$scriptJS = '<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="<?= RACINE_SITE ?>assets/js/script.js"></script>';
$bootstrapFooter = "";
$alerte = "";
$derniere9ImagesAnnonces = afficherDernieres6ImagesAnnonces();


require_once("inc/header.inc.php");
?>

<?php
require_once("inc/footer.inc.php");
?>