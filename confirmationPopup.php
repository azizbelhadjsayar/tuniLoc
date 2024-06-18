
<div id="POPUP" class="hiddenPopup">
    <div id="confirmationPopup">
        <div class="page" id="page1">
            <div id="texte">
                <span style="color: red; font-size: 22px; font-weight: 600;">Exemples:</span> <br><br>
                Si vous souhaitez louer pour 1 jour à partir de demain. Il suffit de sélectionner <strong><?php setlocale(LC_TIME, 'fr_FR.utf8', 'fra');  $date_aujourdhui = strtotime("+1 days"); echo strftime("%A %e %B", $date_aujourdhui); ?></strong>.<br><br>
                Si vous souhaitez louer pour 3 jours à partir de demain. Sélectionnez 
                <?php setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                $date_aujourdhui = strtotime("+1 days");
                $date_aujourdhui_formattee = strftime("%A %e %B", $date_aujourdhui);
                $nombre_jours_a_ajouter = 3;
                $nouvelle_date = strtotime("+$nombre_jours_a_ajouter days");
                $nouvelle_date_formattee = strftime("%A %e %B", $nouvelle_date);
                echo  "<strong>$date_aujourdhui_formattee</strong> jusqu'à <strong>$nouvelle_date_formattee</strong>";?><br>
            </div>
            <div class="footer">
                <button class="button" onclick="ouvrirPage2(this.parentNode.parentNode, this.parentNode.parentNode.parentNode.children[1])">Continuer</button>
            </div>
        </div>
        <div class="page" id="page2" style="display: none">
            <div id="calendrier"></div>
            <div id="info">Location minimum de 1 jour</div>
            <div class="footer">
                <div id="datesInfos">
                    <div id="duree">Durée : <span></span></div>
                    <div id="dates">Dates : <span></span></div>
                </div>
                <button class="button" id="confirmButton" disabled  onclick="displayhidePopup()">Continuer</button>
            </div>
        </div>
        <i id="closeButton" class="fa-regular fa-circle-xmark" onclick="displayhidePopup()"></i>
    </div>
</div>
<script src="air-datepicker/air-datepicker.js"></script>
<script src="confirmationPopup2.js"></script>