<div class="row">
    <div class="mobile-12 columns">
        <h1>Guider</h1>
    </div>
</div>
<div class="row">
    <?php foreach($getProduct as $geteat): ?>
        <div id="product-<?= $geteat['productID']; ?>" class="product mobile-12 columns">
            <div>
                <div class="img" style="background-image: url(/assets/images/products/<?= $geteat['articleImage']; ?>.<?= $geteat['articleExtension']; ?>);"></div>
                <div class="info">
                    <div class="name"><?= $geteat['articleName']; ?></div>
                    <ul class="guides">
                        <?php
                            foreach($getGuide as $guide) {
                                if($guide['productID'] == $geteat['productID']) {
                                    echo '<li><a href="/assets/guides/' . $guide['fileGuide'] . '" target="_blank">' . $guide['title'] . '</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>