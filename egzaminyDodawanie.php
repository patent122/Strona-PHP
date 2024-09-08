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
		<h2 class="pb-2 border-bottom">Dodawanie egzaminu dla ucznia: <?php print("$imie $nazwisko"); ?></h2>
		<div class="row g-4 py-5">
		
			<form action="egzaminy.php" method="post">
				<div class="form-group">
					<label for="imie">Data i czas egzaminu</label>
					<input  type="datetime-local" class="form-control" id="dataICzasEgzaminu" name="dataICzasEgzaminu">
				</div>
				<div class="form-group">
					<label for="wynik">Wynik egzaminu</label><br>
					<select id="wynik" name="wynik">
						<option value="brak">brak wyniku</option>
						<option value="pozytywny">pozytywny</option>
						<option value="negatywny">negatywny</option>
					</select>
				
				</div>
				<br>
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj egzamin">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>