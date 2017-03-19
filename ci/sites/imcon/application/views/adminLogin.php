<?php
    session_start();
    if(isset($_SESSION['name'])) {
  		redirect('/admin');
  	}
?>
<div class="row">
    <div class="mobile-12 columns">
        <h1>Admin login</h1>
        <?php
            if(isset($_GET['error'])) {
                echo '<div class="error">Fel användaruppgifter!</div>';
            }
        ?>
    	<div id="login">
			<form method="post" action="/login/validate">
				<input type="text" name="username" placeholder="Användarnamn"><br />
				<input type="password" name="password" placeholder="Lösenord"><br />
				<input type="submit" value="Logga in">
			</form>
		</div>
    </div>
</div>