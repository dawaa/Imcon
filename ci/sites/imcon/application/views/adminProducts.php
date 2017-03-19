<?php
    function excerpt($str, $startPos=0, $maxLength=100) {
        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength-3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= '...';
            $excerpt   = $excerpt;
        } else {
            $excerpt = $str;
        }

        return strip_tags(nl2br($excerpt));
    }
?>

<div class="row">
    <div class="mobile-12 columns">
		<h1>Produkter</h1>
    </div>
</div>
<div class="row">
    <div class="sidebar mobile-12 desktop-3 columns">
        <div class="mobile-12 columns" style="padding: 0;">
            <a href="?add=product" class="add-product">Lägg till produkt</a>
        </div>
        <div class="categories mobile-12 columns">
            <ul>
                <li class="add">
                    <form class="add-category-form" method="post" action="/admin/addCategory/">
                        <input type="text" id="add-category" name="category" placeholder="Skapa ny kategori" />
                        <input type="submit" value="" class="disabled" />
                    </form>
                </li>
                <?php                    
                    if(empty($_GET['cat'])) {
                        echo '<li class="all active"><div class="parent"><a href="/admin/produkter">Alla</div></li>';
                    } else {
                        echo '<li class="all"><div class="parent"><a href="/admin/produkter">Alla</div></li>';
                    }
                    
                    foreach($getCategories as $getCat) {
                        if(!empty($_GET['cat']) && $getCat['id'] == $_GET['cat']) {
                            echo '<li class="active"><div class="parent"><a href="/admin/produkter?cat=' . $getCat['id'] . '">' . $getCat['articleGroup'] . '</a>';
                        } else {
                            echo '<li><div class="parent"><a href="/admin/produkter?cat=' . $getCat['id'] . '">' . $getCat['articleGroup'] . '</a>';
                        }
                        
                        echo '<a href="/admin/removeCategory/' . $getCat['id'] . '" class="remove" title="Ta bort"><i class="icon-cancel"></i></a></div>';
                        
                        if(!empty($_GET['cat']) && $getCat['id'] == $_GET['cat']) {
                                foreach($getsubCategory as $sub) {
                                    (isset($_GET['sub']) ? $active = ($_GET['sub'] == $sub['unique_id'] ? ' class="sub-active"' : '') : $active = null);
                                    echo('
                                        <div class="subcat">
                                            <a href="/admin/produkter?cat=' . $getCat['id'] . '&sub=' . $sub['unique_id'] . '"' . $active . '>' . $sub['articleGroup'] . '</a>
                                            <a href="/admin/removeSubCat/' . $_GET['cat'] . '/' . $sub['unique_id'] . '" class="remove" title="Ta bort"><i class="icon-cancel"></i></a>
                                        </div>
                                    ');
                                }
                                echo('
                                    <div class="subcat">
                                        <form class="add-subcategory-form" method="post" action="/admin/addSubCategory/' . $_GET['cat'] . '">
                                            <input type="text" id="add-subcategory" name="subcategory" placeholder="Ny underkategori">
                                            <input type="submit" value="" class="disabled" />
                                        </form>
                                    </div>
                                ');
                        }
                        echo '</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <div class="mobile-12 desktop-9 columns">
        <div class="list">
            <?php
                if(isset($_GET['success'])) {
                    echo '<div class="mobile-12 columns" style="padding: 0 0.5rem;">';
                    if($_GET['success'] == 'added') {
                        echo '<div class="success">Produkten har lagts till!</div>';
                    } else if($_GET['success'] == 'edited') {
                        echo '<div class="success">Produkten har ändrats!</div>';
                    } else if($_GET['success'] == 'deleted') {
                        echo '<div class="success">Produkten har tagits bort!</div>';
                    }
                    echo '</div>';
                } else if(isset($_GET['error'])) {
                    echo ('
                        <div class="mobile-12 columns" style="padding: 0 0.5rem;">
                            <div class="error">Ett fel uppstod. Försök igen.</div>
                        </div>
                    ');
                }
            ?>
            <?php 
                if(!empty($_GET['cat'])) {
                    $sql = $this->db->query("SELECT Products.* FROM Products INNER JOIN Categories ON Products.articleGroup = Categories.articleGroup WHERE Categories.id = '" . $_GET['cat'] . "'")->result_array();
                    if(!empty($_GET['cat']) && !empty($_GET['sub'])) {
                        $sql = $this->db->query("SELECT * FROM Products WHERE articleSub = '" . $_GET['sub'] . "'")->result_array();
                    }
                } else {
                    $sql = $this->db->query("SELECT * FROM Products INNER JOIN Categories ON Products.articleGroup = Categories.articleGroup ORDER BY Categories.id ASC")->result_array();
                }
                foreach($sql as $item) {
                    $checkMeasure = $this->db->query("SELECT measurement.measure FROM measurement INNER JOIN Products ON measurement.productID = Products.productID WHERE measurement.productID = '".$item['productID']."'")->result_array();
                    $descWidth = ($checkMeasure[0]['measure'] != '' ? '65%' : '100%');
                    echo('
                        <div class="product mobile-12 columns" data-product="' . $item['productID'] . '">
                            <div>
                                <div class="img" style="background-image: url(/assets/images/products/' . $item['articleImage'] . '.'.$item['articleExtension'].');"></div>
                                <div class="info">
                                    <div class="name">' . $item['articleName'] . '</div>
                                    <div class="desc" style="width: ' . $descWidth . ';">' . excerpt($item['articleDescription']) . '</div>
                    ');
                    if($checkMeasure[0]['measure'] != '') {
                        echo ('
                                    <div class="measurements"><span>Egenskaper</span>
                                        <ul>
                        ');
                        $getMeasure = $this->db->query('
                            SELECT measurement.measure
                            FROM measurement
                            INNER JOIN Products
                            ON Products.productID = measurement.productID
                            WHERE ' . $item['productID'] . ' = measurement.productID
                        ')->result_array();
                        foreach($getMeasure as $measurement){
                            echo ('
                                            <li>- ' . $measurement['measure'] . '</li>
                            ');
                        }
                        echo ('
                                        </ul>
                                    </div>
                        ');
                    }
                    echo ('
                                </div>
                                <a href="?edit=' . $item['productID'] . '" class="edit" title="Redigera"><i class="icon-edit"></i></a>
                                <a class="remove" title="Ta bort"><i class="icon-delete"></i></a>
                            </div>
                        </div>
                    ');
                }
            ?>
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
    
    var urlParam;
    if($.getUrlVar('edit')) {
        urlParam = '/editProduct?edit=' + $.getUrlVar('edit');
    } else if($.getUrlVar('add') == 'product') {
        urlParam = '/addProduct?add=product';
    }
    if($.getUrlVar('edit') || $.getUrlVar('add') == 'product') {
        $(function(e) {
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                data: formData,
                url: urlParam,
                success: function(data) {
                    $('.overlay').show();
                    $('#main').append(data);
                }
            });
        });
    }
</script>