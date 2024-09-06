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
	
	<h2 class="pb-2 border-bottom">Panel użytkownika</h2>
	
<?php
		
	if(isset($_POST['resetHasla'])) {
		
		if(poleWymagane('haslo') && poleWymagane('haslo2') && powtorzenieHasla('haslo', 'haslo2'))
		{
			$id = $_POST['id'];
			$haslo = $_POST['haslo'];
			$haslo2 = $_POST['haslo2'];
			$polaczenie = polaczZBaza();
			$hasloHaszowane = password_hash($haslo, PASSWORD_DEFAULT);
			$sql = "UPDATE Uzytkownicy SET Haslo='$hasloHaszowane' WHERE ID=$id;";
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	
	
?>		
		<p>Twoje konto.</p>
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Imie</th>
		<th>Nazwisko</th>
		<th>Login</th>
		<th>Numer telefonu</th>
		<th>Rola</th>
		<th>Reset hasła</th>
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();

$id = $_SESSION['userId'];
$sql = "SELECT ID, Imie, Nazwisko, Login, Rola, NumerTelefonu FROM Uzytkownicy WHERE ID=$id";

$result = $polaczenie->query($sql);

if ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$login = $row["Login"];
$rola = $row["Rola"];
$numerTelefonu = $row["NumerTelefonu"];
?> 
	<tr>
		<td><?php print("$imie"); ?></td>
		<td><?php print("$nazwisko"); ?></td>
		<td><?php print("$login"); ?></td>
		<td><?php print("$numerTelefonu"); ?></td>
		<td><?php print("$rola"); ?></td>
		
		<td>
			<form action="uzytkownicyResetHasla.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="zPanelu" value="1">
				<input class="btn btn-success" type="submit" name="resetHasla" value="Resetuj hasło">
			</form>
		</td>
	</tr>  
	
<?php
   }
$polaczenie->close();
?>
			
  </tbody>
</table>
</div>
	</div>
	

	
</main>
 <script src="bootstrap.bundle.min.js"></script>

  <?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>