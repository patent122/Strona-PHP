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

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
  </head>

<body>
	<main>
	
	<?php menu(); ?>
		
	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Dodawanie pakietu</h2>
		<div class="row g-4 py-5">
		
			<form action="pakiety.php" method="post">
				<div class="form-group">
					<label for="imie">Nazwa pakietu</label>
					<input type="text" class="form-control" id="nazwaPakietu" name="nazwaPakietu" placeholder="nazwa">
				</div>
				<div class="form-group">
					<label for="iloscLekcji">Ilosc lekcji</label>
					<input type="number" class="form-control" id="iloscLekcji" name="iloscLekcji" placeholder="ilość lekcji">
				</div>
				<div class="form-group">
					<label for="cena">Cena</label>
					<input type="number" class="form-control" id="cena" name="cena" placeholder="cena">
				</div>
				<div class="form-group">
					<label for="opis">Opis</label>
					<input type="text" class="form-control" id="opis" name="opis" placeholder="opis">
				</div>
				<br>
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj pakietu">
			</form>
		
		</div>
	</div>
	
	
</main>
 <script src="bootstrap.bundle.min.js"></script>

  <?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>