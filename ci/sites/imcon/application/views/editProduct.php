<div class="popup edit-product-box">
    <?php
        $getProduct = $this->db->query('
            SELECT *
            FROM Products
            WHERE productID = "' . $_GET['edit'] . '"
        ')->result_array();
        $getCats = $this->db->query("SELECT * FROM Categories")->result_array();
        $getSub = $this->db->query("SELECT * FROM subCategories")->result_array();
        $measurement = $this->db->query("SELECT * FROM measurement WHERE productID = '".$_GET['edit']."'")->result_array();
        $measure = NULL; $article = NULL; $firstmes = TRUE; $secondmes = TRUE;
        foreach($measurement as $mes) {
            if($firstmes) {
                $measure .= $mes['measure'];
                $firstmes = FALSE;
            } else {
                $measure .= ', ' . $mes['measure'];
            }

            if($secondmes) {
                $article .= $mes['articleNumber'];
                $secondmes = FALSE;
            } else {
                $article .= ', ' . $mes['articleNumber'];
            }
        }
    ?>
    <h3>Redigera</h3>
    <form action="/admin/updateEdit" method="post" enctype="multipart/form-data">
        <input type="text" name="articleName" value="<?= $getProduct[0]['articleName']; ?>" placeholder="Namn" title="Namn" required>
        <select name="articleGroup" title="Kategori" class="articleGroup">
            <?php  
                foreach($getCats as $options) {
                    if($getProduct[0]['articleSub'] == '') {
                        $select = (($options['articleGroup'] == $getProduct[0]['articleGroup']) ? ' selected' : '');
                    } else {
                        $select = '';
                    }
                    echo '<option value="' . $options['articleGroup'] . '"' . $select . '>' . $options['articleGroup'] . '</option>';
                    
                    foreach($getSub as $subs) {
                        if($subs['id'] == $options['id']) {
                            $selectSub = (($subs['unique_id'] == $getProduct[0]['articleSub']) ? ' selected' : '');
                            echo '<option value="'.$options['articleGroup'].'-'.$subs['unique_id'].'"' . $selectSub . '>- ' . $subs['articleGroup'] . '</option>';
                        }
                    }
                }
            ?>
        </select>
        <input type="text" name="measurement" value="<?= $measure; ?>" placeholder="Egenskaper" title="Egenskaper (separera med komma (,)">
        <input type="text" name="articleNumber" value="<?= $article; ?>" placeholder="Artikelnummer" title="Artikelnummer (separera med komma (,)" required>
        <textarea name="articleDescription" placeholder="Beskrivning" title="Beskrivning"><?= $getProduct[0]['articleDescription']; ?></textarea>
        <input type="file" name="file_upload">
        <input type="hidden" name="id" value="<?= $_GET['edit']; ?>">
        <input type="submit" value="Spara">
    </form>
</div>

<script>
    $('select').selectBox({
        mobile: true,
        menuTransition: 'default',
        hideOnWindowScroll: false
    });
</script>