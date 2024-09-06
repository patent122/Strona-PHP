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
	
<?php menu(); 

	$uczenID = -1;
	$imie = "";
	$nazwisko = "";
	if(isset($_POST['uczenID']))
	{
		$uczenID = $_POST['uczenID'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID = $uczenID";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
		}
		$polaczenie->close();
	}
?>
	

		
	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Zakup pakietu dla ucznia: <?php print("$imie $nazwisko"); ?></h2>
		<div class="row g-4 py-5">
		
		
		
		<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Nazwa pakietu</th>
		<th>Ilosc lekcji</th>
		<th>Cena</th>
		<th>Opis</th>
		<th>Zakup</th>
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();
$sql = "SELECT ID, NazwaPakietu, IloscLekcji, Cena, Opis FROM Pakiety";
$result = $polaczenie->query($sql);

while ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$nazwaPakietu = $row["NazwaPakietu"];
$iloscLekcji = $row["IloscLekcji"];
$cena = $row["Cena"];
$opis = $row["Opis"];
?> 
	<tr>
		<td><?php print("$nazwaPakietu"); ?></td>
		<td><?php print("$iloscLekcji"); ?></td>
		<td><?php print("$cena"); ?></td>
		<td><?php print("$opis"); ?></td>
		<td>
			<form action="zakupionePakiety.php" method="post">
				<input type="hidden" name="idPakietu" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-primary" type="submit" name="zakup" value="Zakup">
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