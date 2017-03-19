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
        <div class="search mobile-12 tablet-6 desktop-12 columns">
            <form class="search-form" method="get" action="/produkter/search">
                <input type="text" id="search-text" name="q" placeholder="Sök produkt" />
                <input type="submit" id="search-submit" value="" class="disabled" />
            </form>
        </div>
        <div class="categories mobile-12 tablet-6 desktop-12 columns">
            <ul>
                <?php
                    if(empty($_GET['cat'])) {
                        echo '<li class="all active"><div class="parent"><a href="/produkter">Alla</a></div></li>';
                    } else {
                        echo '<li class="all"><div class="parent"><a href="/produkter">Alla</a></div></li>';
                    }
                    
                    foreach($listCategories as $categories) {
                        $urlQuery = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
                        $url = '?cat='.$categories['id'];
                        $currentUrl = ($url == $urlQuery ? ' class="active"' : ''); 
                        
                        if(!empty($_GET['cat']) && $categories['id'] == $_GET['cat']) {
                            echo '<li class="active"><div class="parent"><a href="/produkter?cat=' . $categories['id'] . '"' . $currentUrl . '>' . $categories['articleGroup'] . '</a></div>';
                        } else {
                            echo '<li><div class="parent"><a href="/produkter?cat=' . $categories['id'] . '"' . $currentUrl . '>' . $categories['articleGroup'] . '</a></div>';
                        }
                        
                        if(!empty($_GET['cat']) && $categories['id'] == $_GET['cat']) {
                            foreach($getsubCategory as $sub) {
                                (isset($_GET['sub']) ? $active = ($_GET['sub'] == $sub['unique_id'] ? ' class="sub-active"' : '') : $active = null);
                                echo '<div class="subcat"><a href="/produkter?cat=' . $categories['id'] . '&sub=' . $sub['unique_id'] . '"' . $active . '>' . $sub['articleGroup'] . '</a></div>';
                            }
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
                        <div class="product mobile-12 columns">
                            <a href="/produkter/produkt?id=' . $item['productID'] . '">
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
                        foreach($getMeasure as $measurement) {
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
                            </a>
                        </div>
                    ');
                }
            ?>
        </div>
    </div>
</div>