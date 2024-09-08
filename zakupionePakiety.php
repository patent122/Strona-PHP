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
	if(jestRola('uczen'))
	{
		$uczenID = $_SESSION['userId'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID = $uczenID";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
		}
		$polaczenie->close();
	}
	else if(jestRola('instruktor') && isset($_POST['uczenID']))
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
		<h2 class="pb-2 border-bottom">Zakupione pakiety ucznia: <?php print("$imie $nazwisko"); ?></h2>

<?php

	if(isset($_POST['zakup']) && $uczenID!=-1 && jestRola('uczen')) {
		$idPakietu = $_POST['idPakietu'];
		if(poleWymagane('idPakietu')) {
			$polaczenie = polaczZBaza();

			$sql = "INSERT INTO ZakupionePakiety (UczenID, PakietID) VALUES ($uczenID, $idPakietu);";

			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie']) && $uczenID!=-1 && jestRola('uczen')) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM ZakupionePakiety WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}

?>		
		<p>This is a paragraph.</p>

 <?php if(jestRola('uczen')) { ?>
		<form action="zakupionePakietyDodawanie.php" method="post">
			<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
			<input class="btn btn-primary" type="submit" name="zakupPakietuDlaUcznia" value="Zakup pakiet">
		</form>
 <?php } ?>
		<div class="row g-4 py-5">

<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Data zakupu</th>
		<th>Cena</th>
		<th>Opis</th>
		<th>Lekcje wyk./wszystkie</th>
		<th>Status</th>
		<th>Lekcje</th>
		 <?php if(jestRola('uczen')) { ?>
		<th>Usuwanie</th>
		<?php } ?>
    </tr>
  </thead>

  <tbody>

<?php

$polaczenie = polaczZBaza();

$sql = "SELECT ZP.ID, ZP.DataZakupu, ZP.Status, IloscWykorzystanychLekcji(ZP.ID) AS 'Wykorzystane', P.IloscLekcji,P.Cena, P.Opis
FROM ZakupionePakiety ZP JOIN Pakiety P ON P.ID = ZP.PakietID
WHERE ZP.UczenID = $uczenID;";

$result = $polaczenie->query($sql);


while ($row = $result->fetch_assoc()) {

$id = $row["ID"];
$dataZakupu = $row["DataZakupu"];
$status = $row["Status"];

$wykorzystane = $row["Wykorzystane"];
$iloscLekcji = $row["IloscLekcji"];
$cena = $row["Cena"];
$opis = $row["Opis"];
?> 
	<tr>
		<td><?php print("$dataZakupu"); ?></td>
		<td><?php print("$cena"); ?></td>
		<td><?php print("$opis"); ?></td>
		<td><?php print("$wykorzystane / $iloscLekcji"); ?></td>
		<td><?php print("$status"); ?></td>

		<td>
			<form action="lekcje.php" method="post">
				<input type="hidden" name="pakietID" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-primary" type="submit" name="lekcje" value="Lekcje">
			</form>
		</td>
		<td>
		<?php if(jestRola('uczen')) { ?>
			<form action="zakupionePakiety.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-danger" type="submit" name="usuwanie" value="Usun">
			</form>
			<?php } ?>
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

</body>
</html>