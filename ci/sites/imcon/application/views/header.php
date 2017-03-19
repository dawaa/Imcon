<?php $getInfo = $this->db->query("SELECT * FROM ContactInfo")->row_array(); ?>
<div class="top show-for-desktop">
    <div class="contact-info">
        <ul>
            <li>
                <i class="icon-phone"></i>
                <div><?= $getInfo['Telephone']; ?></div>
            </li>
            <li>
                <i class="icon-mail"></i>
                <div><?= $getInfo['Email']; ?></div>
            </li>
        </ul>
    </div>
</div>
<nav class="main-nav">
    <div class="logo">
        <a href="/"><div></div></a>
    </div>
    <ul class="show-for-desktop">
        <li data-content="home"><a href="/">Hem</a></li>
        <li data-content="products"><a href="/produkter">Produkter</a></li>
        <li data-content="services"><a href="/tjanster">Tjänster</a></li>
        <li data-content="guides"><a href="/guider">Guider</a></li>
        <li data-content="about"><a href="/om-oss">Om oss</a></li>
        <li data-content="contact" class="button"><a href="/kontakt">Kontakta oss</a></li>
    </ul>
    <div class="mobile hide-for-desktop">
        <div class="toggle"><i class="icon-menu"></i></div>
        <ul>
            <li data-content="home"><a href="/">Hem</a></li>
            <li data-content="products"><a href="/produkter">Produkter</a></li>
            <li data-content="services"><a href="/tjanster">Tjänster</a></li>
            <li data-content="guides"><a href="/guider">Guider</a></li>
            <li data-content="about"><a href="/om-oss">Om oss</a></li>
            <li data-content="contact" class="button"><a href="/kontakt">Kontakta oss</a></li>
        </ul>
    </div>
</nav>