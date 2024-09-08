<?php
	session_start();
	require("funkcje.php");
?>



<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Patryk Panek">
    <title>Nauka jazdy</title>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    
		<link href="bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">

  </head>

<body>
	<main>
	
	<?php menu(); ?>
		
	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Dodawanie samochodu</h2>
		<div class="row g-4 py-5">
		
			<form action="samochody.php" method="post">
				<div class="form-group">
					<label for="marka">Marka</label>
					<input type="text" class="form-control" id="marka" name="marka" placeholder="marka samochodu">
				</div>
				<div class="form-group">
					<label for="model">Model</label>
					<input type="text" class="form-control" id="model" name="model" placeholder="model samochodu">
				</div>
				<div class="form-group">
					<label for="rokProdukjci">Rok produkcji</label>
					<input type="number" class="form-control" id="rokProdukjci" name="rokProdukjci" placeholder="2024">
				</div>
				<br>
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj samochod">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>