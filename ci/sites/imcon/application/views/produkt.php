<?php
    $subGet = $this->db->query("SELECT articleGroup FROM subCategories WHERE unique_id = '" . $url['articleSub']. "'")->row_array();
    $geteet = $this->db->query("SELECT id FROM Categories WHERE articleGroup = '" . $url['articleGroup'] . "'")->row_array();
    $breadcrumbs = '<a href="/produkter">Produkter</a>';
    if($url['articleSub'] == '') {
        $breadcrumbs .= ' &raquo; <a href="/produkter?cat=' . $geteet['id'] . '">' . $url['articleGroup'] . '</a>';
    } else {
        $breadcrumbs .= ' &raquo; <a href="/produkter?cat=' . $geteet['id'] . '">' . $url['articleGroup'] . '</a> &raquo; <a href="/produkter?cat=' . $geteet['id'] . '&sub=' . $url['articleSub'] . '">' . $subGet['articleGroup'] . '</a>';
    }
?>

<div class="row">
    <div class="mobile-12 columns">
        <h3><?= $breadcrumbs; ?></h3>
    </div>
</div>
<div class="row">
    <div class="sidebar mobile-12 desktop-3 columns">
        <div class="search mobile-12 tablet-6 desktop-12 columns">
            <form class="search-form" method="get" action="/produkter/search">
                <input type="text" id="search-text" name="q" placeholder="Sök produkt" />
                <input type="submit" id="search-submit" value="" class="disabled" />
            </form>
        </div>
        <div class="categories mobile-12 tablet-6 desktop-12 columns">
            <ul>
                <li class="all"><div class="parent"><a href="/produkter">Alla</a></div></li>
                <?php   
                    foreach($listCategories as $categories) {
                        $urlQuery = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';

                        $url2 = '?cat='.$categories['id'];
                        $currentUrl = ($url2 == $urlQuery ? ' class="active"' : '');
                        $currentCat = $this->db->query("SELECT id FROM Categories WHERE articleGroup = '" . $url['articleGroup'] . "'")->row_array();
                        $currentSubcat = $this->db->query("SELECT id FROM subCategories WHERE unique_id = '" . $url['articleSub']. "'")->row_array();

                        if($trying2bcool[0]['id'] == $categories['id'])
                        {
                            echo '<li class="active"><div class="parent"><a href="/produkter?cat=' . $categories['id'] . '"' . $currentUrl . '>' . $categories['articleGroup'] . '</a></div>';

                             foreach($listSubs as $subss)
                             {
                                if($trying2bcool[0]['id'] == $subss['id']) {
                                    $active = ($trying2bcool[0]['articleSub'] == $subss['unique_id'] ? ' class="sub-active"' : '');
                                    //(isset($_GET['id']) ? $active = ($_GET['sub'] == $sub['unique_id'] ? ' class="sub-active"' : '') : $active = null);
                                    echo '<div class="subcat"><a href="/produkter?cat=' . $categories['id'] . '&sub=' . $subss['unique_id'] . '"' . $active . '>' . $subss['articleGroup'] . '</a></div>';
                                 } 
                             }
                        
                        } else {
                            echo '<li><div class="parent"><a href="/produkter?cat=' . $categories['id'] . '"' . $currentUrl . '>' . $categories['articleGroup'] . '</a></div>';
                        }
                        echo '</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="mobile-12 desktop-9 columns">
        <div class="product-box">
            <div class="product-img mobile-12 tablet-4 columns">
                <a href="/assets/images/products/<?= $url['articleImage']; ?>.<?= $url['articleExtension']; ?>" target="_blank"><img src="/assets/images/products/<?= $url['articleImage']; ?>.<?= $url['articleExtension']; ?>" /></a>
            </div>
            <div class="product-info mobile-12 tablet-8 columns">
                <h1><?= $url['articleName']; ?></h1>
                <?php $checkMeasure = $this->db->query('SELECT measurement.measure FROM measurement INNER JOIN Products ON measurement.productID = Products.productID WHERE measurement.productID = "' . $_GET['id'] . '"')->row_array(); ?>
                <?php if($checkMeasure['measure'] != ''): ?>
                <div class="measurements">
                    <span>Egenskaper</span>
                    <select name="measurements">
                        <?php
                            $firstMeasure = true;
                            foreach($getMeasure as $measurement) {
                                $selected = ($firstMeasure ? 'selected' : '');
                                echo '<option value="' . $measurement['measure'] . '" ' . $selected . '>' . $measurement['measure'] . '</option>';
                                $firstMeasure = false;
                            }
                        ?>
                    </select>
                </div>
                <?php endif; ?>
                <div class="article-number">
                    <span>Artikelnummer</span>
                    <div class="value">
                        <?php
                            $firstMeasure2 = true;
                            foreach($getMeasure2 as $measurement) {
                                if($firstMeasure2) {
                                    $currentMeasure = $measurement['articleNumber'];
                                    echo $currentMeasure;
                                }
                                $firstMeasure2 = false;
                            }
                        ?>
                    </div>
                </div>
                <form action="/kontakt" method="get">
                    <input type="hidden" name="option" value="price">
                    <input type="hidden" name="article" value="<?= $currentMeasure; ?>">
                    <input type="submit" class="price-button" value="Kontakta oss för pris">
                </form>
                <div class="desc">
                    <p><?= nl2br($url['articleDescription']); ?></p>
                </div>
                <?php
                    if($getGuides) {
                        echo '<div class="guides"><h4>Guider</h4><ul>';
                        foreach($getGuides as $guide) {
                            echo '<li><a href="/assets/guides/' . $guide['fileGuide'] . '" target="_blank">' . $guide['title'] . '</a></li>';
                        }
                        echo '</ul></div>';
                    }
                ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<script>
    // Get URL parameter values
    $.extend({
        getUrlVars: function(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name){
            return $.getUrlVars()[name];
        }
    });
    
    $('select[name="measurements"]').on('change', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var value = $(this).val();
        var id = $.getUrlVar('id');
        $.ajax({
            context: this,
            type: 'POST',
            data: formData,
            url: '/measurement?id=' + id + '&measure=' + value,
            success: function(data) {
                $('.article-number .value').html(data);
                $('input[name="article"]').val(data);
            }
        });
    });
</script>