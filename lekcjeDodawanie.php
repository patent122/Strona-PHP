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
	<link href="bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">

  </head>

<body>
	<main>
	
<?php menu(); 

	$uczenID = -1;
	$pakietID = -1;
	$imie = "";
	$nazwisko = "";
	$nazwaPakietu = "";
	
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
		
		$pakietID = $_POST['pakietID'];
		$sql = "SELECT P.NazwaPakietu FROM ZakupionePakiety ZP JOIN Pakiety P ON ZP.PakietID = P.ID WHERE ZP.ID = $pakietID;";
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$nazwaPakietu = $row["NazwaPakietu"];
		}
		
		$polaczenie->close();
	}
?>
			
	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Dodawanie lekcji dla ucznia: <?php print("$imie $nazwisko"); ?></h2>
		<h3 class="pb-3 border-bottom">Dodawanie lekcji do pakietu: <?php print("$nazwaPakietu"); ?></h3>
		<div class="row g-4 py-5">
		
			<form action="lekcje.php" method="post">
				<div class="form-group">
					<label for="imie">Data i czas lekcji</label>
					<input type="datetime-local" class="form-control" id="dataICzasLekcji" name="dataICzasLekcji">
				</div>
				<div class="form-group">
					
<?php 
		$idInstruktora = $_SESSION['userId'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID=$idInstruktora";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
			print("<label>Instruktor: $imie $nazwisko</label><br>");
		}
?>			
				</div>
				
				<div class="form-group">
					<label for="samochod">Samochód:</label><br>
					<select id="samochod" name="samochod">
<?php 
		$sql = "SELECT ID, Marka,Model,RokProdukcji FROM Samochody";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		
		while ($row = $result->fetch_assoc()) {
			$idSamochodu = $row["ID"];
			$marka = $row["Marka"];
			$model = $row["Model"];
			$rokProdukcji = $row["RokProdukcji"];
			print("<option value=\"$idSamochodu\">$marka $model ($rokProdukcji r.)</option>");
		}
		
		
?>
					</select>
				
				</div>
				
				<br>
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input type="hidden" name="pakietID" value="<?php print("$pakietID"); ?>">
				
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj lekcje">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>