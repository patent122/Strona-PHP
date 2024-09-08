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
		<h2 class="pb-2 border-bottom">Edycja egzaminu dla ucznia: <?php print("$imie $nazwisko"); ?></h2>
		<div class="row g-4 py-5">
		
		<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT DataEgzaminu, CzasEgzaminu, Wynik FROM Egzaminy WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$dataEgzaminu = $row["DataEgzaminu"];
$czasEgzaminu = $row["CzasEgzaminu"];
$dataICzasEgzaminu = $dataEgzaminu."T".$czasEgzaminu;

$wynik = $row["Wynik"];
$opcjaBrak= "";
$opcjaPozytywny= "";
$opcjaNegatywny= "";
if(!isset($wynik))
{
	$opcjaBrak = "SELECTED";
}
else if($wynik == "pozytywny")
{
	$opcjaPozytywny= "SELECTED";
}
else if($wynik == "negatywny")
{
	$opcjaNegatywny= "SELECTED";
}


		?>
			<form action="egzaminy.php" method="post">
				<div class="form-group">
					<label for="imie">Data i czas egzaminu</label>
					<input  type="datetime-local" class="form-control" id="dataICzasEgzaminu" name="dataICzasEgzaminu" value="<?php print($dataICzasEgzaminu); ?>">
				</div>
				<div class="form-group">
					<label for="wynik">Wynik egzaminu</label><br>
					<select id="wynik" name="wynik">
						
						<option value="brak" <?php print($opcjaBrak); ?> > brak wyniku</option>
						<option value="pozytywny" <?php print($opcjaPozytywny); ?> >pozytywny</option>
						<option value="negatywny" <?php print($opcjaNegatywny); ?> >negatywny</option>
					</select>
				</div>
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj egzamin">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>