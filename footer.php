
    <link rel="stylesheet" href="styles.css">

    <footer class="footer">
        <div>
            <h2>À propos de nous</h2>
            <p>Université Gustave Eiffel</p>
            <p><a href="#" onclick="showLegal()">Mentions légales</a></p>
            <p>© 2025 Tous droits réservés</p>
        </div>
    
        <div>
            <h2>Restons connectés</h2>
            <p>Vous pouvez nous contacter</p>
            <p>au 01 02 03 04 05,
            <p>du lundi au vendredi de 9h à 17h</p>
            <p>ou par courriel : 
            <p><a href="mailto:clara.moubarak@edu.univ-eiffel.fr">clara.moubarak@edu.univ-eiffel.fr</a></p>
        </div>
    </footer>

    <!-- Modal -->
    <div id="footerModal" class="footer-modal">
        <div class="footer-modal-content">
            <span class="footer-close" onclick="closeModal()">&times;</span>
            <h2>Mentions Légales</h2>
            <div class="footer-legal-content">
                <h3>Informations Générales</h3>
                <p>Le présent site est édité par Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>
    
                <h3>Mentions Légales</h3>
                <p>Ce site est géré par une équipe composée de Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN. Il est localisé au 2 Rue Albert Einstein, 77420 Champs-sur-Marne.</p>

                <h3>Équipe</h3>
                <p><strong>Conception Graphique</strong><br>
                Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>
 
                <p><strong>Développement Front</strong><br>
                    Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>

                <p><strong>Développement Back</strong><br>
                    Clara MOUBARAK.</p>

                <h3>Hébergeur</h3>
                <p>Ce site est hébergé par O2Switch et il est localisé au 222-224 Boulevard Gustave Flaubert, 63000 Clermont-Ferrand.</p>
    
                <h3>Protection des Données et RGPD</h3>
                <p>Nous sommes pleinement engagés à respecter le Règlement Général sur la Protection des Données (RGPD) afin de garantir la sécurité et la confidentialité de vos données personnelles. Toutes les informations collectées sur notre Environnement Numérique de Travail (ENT) sont traitées conformément aux normes en vigueur. Nous mettons en place des mesures de sécurité robustes pour protéger vos données contre tout accès non autorisé, divulgation, altération ou perte.</p>
                <p>Vous disposez également de droits concernant vos données, tels que l'accès, la rectification, la suppression, la limitation du traitement, ainsi que la possibilité de s'opposer à leur utilisation ou de demander leur portabilité. Pour toute question ou pour exercer vos droits, n'hésitez pas à nous contacter à l'adresse suivante : clara.moubarak@edu.univ-eiffel.fr.</p>
            </div>
        </div>
    </div>

    <script>
        function showLegal() {
            document.getElementById('footerModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('footerModal').style.display = "none";
        }

        // Fermer le modal si l'on clique en dehors du contenu du modal
        window.onclick = function(event) {
            var modal = document.getElementById('footerModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
