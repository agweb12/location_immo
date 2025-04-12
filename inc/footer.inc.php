<footer>
            <div class="footer-details">
                <div class="box-1">
                    <div class="box">
                        <h3>Restez en contact</h3>
                        <div class="coordonnees">
                            <div class="mini-box">
                                <i class="fa-solid fa-location-pin" style="color: var(--text-grey);"></i>
                                <p>10 rue du terrage, 75010 Paris</p>
                            </div>
                            <div class="mini-box">
                                <i class="fa-solid fa-phone" style="color: var(--text-grey);"></i>
                                <p>+33 7 79 13 44 95</p>
                            </div>
                            <div class="mini-box">
                                <i class="fa-solid fa-envelope" style="color: var(--text-grey);"></i>
                                <p>contact@location-immo.org</p>
                            </div>
                        </div>
                        <div class="row-socialmedia">
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-linkedin-in"></i>
                            <i class="fa-brands fa-youtube"></i>
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                    </div>
                    <div class="box">
                        <h3>Liens Utiles</h3>
                        <ul>
                            <li><i class="fa-solid fa-chevron-right"></i><a href="<?= RACINE_SITE ?>aboutUs.php">À propos de</a></li>
                            <li><i class="fa-solid fa-chevron-right"></i><a href="<?= RACINE_SITE ?>contact.php">Contactez-Nous</a></li>
                            <li><i class="fa-solid fa-chevron-right"></i><a href="<?= RACINE_SITE ?>adverts.php">Our Services</a></li>
                            <li><i class="fa-solid fa-chevron-right"></i><a href="<?= RACINE_SITE ?>privacyPolicy.php">Politique de Confidentialité</a></li>
                        </ul>
                    </div>
                </div>
                <div class="box-1">
                    <div class="box">
                        <h3>Photo Gallery</h3>
                        <div class="photo-gallery">
                            <?php foreach($derniere9ImagesAnnonces as $image): ?>
                                <img src="<?= RACINE_SITE ?>assets/img/<?= $image['photo'] ?>" alt="property">
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="box">
                        <div class="newsletter">
                            <h3>S'abonner à notre newsletter</h3>
                            <p>Si vous souhaitez suivre nos nouvelles annonces, abonnez-vous !</p>
                            <div class="input-group">
                                <input type="search" name="search" id="search" placeholder="Your email">
                                <a href="" class="bouton-primary">S'Inscrire</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="division">
            <div class="details-cop">
                <div class="copyright">
                    <p><a href="">Location Immo</a>, Tous droits reservés. Conçu par <a href="">GRAZIANI Alexandre</a></p>
                </div>
                <div class="details-menu">
                    <a href="<?= RACINE_SITE ?>index.php">Accueil</a>
                    <a href="<?= RACINE_SITE ?>adverts.php">Toutes les annonces</a>
                    <a href="<?= RACINE_SITE ?>addAdvert.php">Ajouter une annonce</a>
                </div>
            </div>
        </footer>
    </section>
    <?= $scriptJS ?>
    <?= $bootstrapFooter ?>
</body>

</html>