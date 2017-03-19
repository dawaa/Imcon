<?php $arr = explode(' ',trim($template['title'])); ?>
<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400">
        <link rel="stylesheet" href="/assets/css/jquery.selectBox.css">
        <link rel="stylesheet" href="/assets/css/slider.css">
        <link rel="stylesheet" href="/assets/css/animation.css">
        <link rel="stylesheet" href="/assets/css/icons.css">
        <link rel="stylesheet" href="/assets/css/responsive.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/admin.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script src="/assets/js/jquery.selectBox.min.js"></script>

        <title><?= $title; ?></title>
        <?php echo $template['metadata']; ?>
    </head>

    <body class="admin <?= $classes; ?>">
        <header><?php include('./ci/sites/imcon/application/views/header.php'); ?></header>
        
        <section id="main">
            <div class="row">
                <div id="admin-menu" class="mobile-12 columns">
                    <ul>
                        <li data-content="admin-home"><a href="/admin">Hem</a></li>
                        <li data-content="admin-products"><a href="/admin/produkter">Produkter</a></li>
                        <li data-content="admin-services"><a href="/admin/tjanster">Tjänster</a></li>
                        <li data-content="admin-guides"><a href="/admin/guider">Guider</a></li>
                        <li data-content="admin-about"><a href="/admin/om-oss">Om oss</a></li>
                        <li data-content="admin-contact"><a href="/admin/kontakt">Kontakta oss</a></li>
                    </ul>
                </div>
            </div>
            <?php echo $template['body']; ?>
            <div class="overlay">
                <div class="loading"><i class="icon-loading animate-spin"></i></div>
            </div>
        </section>
        
        <footer><?php include('./ci/sites/imcon/application/views/footer.php'); ?></footer>
        <script src="/assets/js/scripts.js"></script>
    </body>
</html>