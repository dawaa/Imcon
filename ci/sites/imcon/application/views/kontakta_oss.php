 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
 <script>
    function initialize() {
        var myLatlng = new google.maps.LatLng(59.5165017,17.889579);
        var mapOptions = {
            zoom: 17,
            center: myLatlng,
            draggable: false,
            disableDefaultUI: true,
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            disableDoubleClickZoom: true
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Imcon AB'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="contact-info">
    <div class="row">
        <div class="mobile-12 columns">
            <h1>Kontakta oss</h1>
        </div>
    </div>
    <div class="row">
        <div class="mobile-12 tablet-8 columns">
            <h4>Telefon</h4><div class="info"><?= $contact['Telephone']; ?></div>
            <h4>Fax</h4><div class="info"><?= $contact['Fax']; ?></div>
            <h4>Email</h4><div class="info"><?= $contact['Email']; ?></div>
            <h4>Adress</h4><div class="info"><?= $contact['Address']; ?></div>
            <h4>Postadress</h4><div class="info"><?= $contact['ZipCode']; ?></div>
        </div>
        <div class="logos tablet-4 columns show-for-tablet-up">
            <a href="/"><div class="imcon"></div></a>
            <a href="http://www.martin-eng.com/" target="_blank"><div class="martin"></div></a>
        </div>
    </div>
    <div class="row">
        <div class="mobile-12 columns">
            <h3>Kontaktformulär</h3>
            <?php
                if(isset($_GET['success'])) {
                    echo '<div class="success">Ditt mail har skickats! Vi återkommer så snarast som möjligt.</div>';
                } else if(isset($_GET['error'])) {
                    echo '<div class="error">Ett fel uppstod. Försök igen.</div>';
                }
            ?>
            <form method="post" action="/kontakta_oss/sendEmail">
                <select name="question">
                    <?= (isset($_GET['option'])) ? '<option value="Beställning" selected>Beställning</option>' : '<option value="Beställning" selected>Beställning</option>'; ?>
                    <option value="Frågor">Frågor</option>
                    <option value="Övrigt">Övrigt</option>
                </select>
                <input type="email" name="email" placeholder="E-mail" required>
                <textarea name="contactText" cols="25" rows="10" required><?php
                    if(isset($_GET['article'])) {
                        $checkMeasure = $this->db->query("SELECT measurement.measure FROM measurement INNER JOIN Products ON measurement.productID = Products.productID WHERE measurement.articleNumber = '".$_GET['article']."'")->result_array();
                        $measure = ($checkMeasure[0]['measure'] != '' ? ' (' . $getProduct['measure'] . ')' : '');
                        echo 'Produkt: ' . $getProduct['articleName'] . $measure . "\n" . 'Artikelnummer: ' . $getProduct['articleNumber'];
                        echo "\n" . '---------------------------' . "\n";
                    }
                ?></textarea>
                <div class="g-recaptcha"
                     style="margin-bottom: 20px;"
                     data-sitekey="6LcohRkUAAAAADr2WUYBP0SgqQrdD-RYl_kIZwbu"></div>
                <input type="submit" value="Skicka">
            </form>
        </div>
    </div>
</div>

<div id="map-canvas"></div>



