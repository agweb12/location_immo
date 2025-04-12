<?php
require_once("inc/functions.inc.php");
$h1 = "Politique Confidentialité - Location Immo";
$description = "Politique de confidentialité de Location Immo";
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