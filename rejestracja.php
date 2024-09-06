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
		<h2 class="pb-2 border-bottom">Rejestracja</h2>
		<div class="row g-4 py-5">
		
			<form action="instruktorzy.php" method="post">
				<div class="form-group">
					<label for="imie">Imie</label>
					<input type="text" class="form-control" id="imie" name="imie" placeholder="imie instruktora">
				</div>
				<div class="form-group">
					<label for="nazwisko">Nazwisko</label>
					<input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="nazwisko instruktora">
				</div>
				<div class="form-group">
					<label for="numerTelefonu">Numer telefonu</label>
					<input type="text" class="form-control" id="numerTelefonu" name="numerTelefonu" placeholder="telefon">
				</div>
				<br>
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj instruktora">
			</form>
		
		</div>
	</div>
	
	
</main>
 <script src="bootstrap.bundle.min.js"></script>

  <?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>