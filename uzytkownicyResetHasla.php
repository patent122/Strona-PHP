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
		
	<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT Imie, Nazwisko, Login, Rola, NumerTelefonu FROM Uzytkownicy WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$login = $row["Login"];
$rola = $row["Rola"];
$numerTelefonu = $row["NumerTelefonu"];
		
		?>
		
		
	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Dodawanie uzytkownika</h2>
		<?php "<p>Reset hasla uzytkownika: $imie $nazwisko, login: $login, rola:$rola </p>" ?>
		<div class="row g-4 py-5">
		
			<form action="<?php
			if(isset($_POST['zPanelu']))
			{
				print("panelUzytkownika.php");
			}
			else
			{
				print("uzytkownicy.php");
			}
			?>" method="post">
				<div class="form-group">
					<label for="login">hasło</label>
					<input type="password" class="form-control" minlength="5" id="haslo" name="haslo" placeholder="hasło">
				</div>
				<div class="form-group">
					<label for="login">powtorz hasło</label>
					<input type="password" class="form-control" minlength="5" id="haslo2" name="haslo2" placeholder="powtorzone hasło">
				</div>
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-primary" type="submit" name="resetHasla" value="Reset hasła uzytkownika">
			</form>
		
		</div>
	</div>
	
	
</main>
 <script src="bootstrap.bundle.min.js"></script>

  <?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>