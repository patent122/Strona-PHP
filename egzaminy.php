<?php
	session_start();
	require("funkcje.php");

	if (isset($_POST['dodawanie'])) {
		$uczenID = $_SESSION['userId']; 
		
		if ($uczenID != -1 && jestRola('uczen')) {
			$dataICzasEgzaminu = $_POST['dataICzasEgzaminu'];
			$wynik = $_POST['wynik'];
			
			if (poleWymagane('dataICzasEgzaminu')) {
				$polaczenie = polaczZBaza();
				list($dataEgzaminu, $czasEgzaminu) = explode('T', $dataICzasEgzaminu);

				$dataEgzaminu = $polaczenie->real_escape_string($dataEgzaminu);	
				$czasEgzaminu = $polaczenie->real_escape_string($czasEgzaminu);	
				$wynik = $polaczenie->real_escape_string($wynik);	

				$sql = "INSERT INTO Egzaminy (DataEgzaminu, CzasEgzaminu, UczenID, Wynik) VALUES ('$dataEgzaminu', '$czasEgzaminu', $uczenID, '$wynik');";

				$polaczenie->query($sql);
				$polaczenie->close();
			}
		}
		header("Location: egzaminy.php");
		exit();
	}
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
	else if(jestRola('instruktor')) {
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
		<h2 class="pb-2 border-bottom">Egzaminy ucznia: <?php print("$imie $nazwisko"); ?></h2>
	
<?php	
	
	if(isset($_POST['dodawanie']) && $uczenID!=-1 && jestRola('uczen')) {
		
		$dataICzasEgzaminu = $_POST['dataICzasEgzaminu'];

		
		$wynik = $_POST['wynik'];
		
		if(poleWymagane('dataICzasEgzaminu')) {
			$polaczenie = polaczZBaza();
			
			$dataEgzaminu="";
			$czasEgzaminu="";
			list($dataEgzaminu, $czasEgzaminu) = explode('T', $dataICzasEgzaminu);

			$dataEgzaminu = $polaczenie->real_escape_string($dataEgzaminu);	
			$czasEgzaminu = $polaczenie->real_escape_string($czasEgzaminu);	
			$wynik = $polaczenie->real_escape_string($wynik);	
		
			$sql = "INSERT INTO Egzaminy (DataEgzaminu, CzasEgzaminu, UczenID) VALUES ('$dataEgzaminu', '$czasEgzaminu', $uczenID);";
			if(isset($wynik) && $wynik!="") {
				$wynik = $polaczenie->real_escape_string($wynik);	
				$sql = "INSERT INTO Egzaminy (DataEgzaminu, CzasEgzaminu, UczenID, Wynik) VALUES ('$dataEgzaminu', '$czasEgzaminu', $uczenID, '$wynik');";
			}
			
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['edycja']) && $uczenID!=-1 && jestRola('uczen')) {
		$id = $_POST['id'];
		$dataICzasEgzaminu = $_POST['dataICzasEgzaminu'];
		
		$wynik = $_POST['wynik'];
		
		if(poleWymagane('dataICzasEgzaminu')) {
			$polaczenie = polaczZBaza();
		
			$id = $polaczenie->real_escape_string($id);	
			$dataEgzaminu="";
			$czasEgzaminu="";
			list($dataEgzaminu, $czasEgzaminu) = explode('T', $dataICzasEgzaminu);

			$dataEgzaminu = $polaczenie->real_escape_string($dataEgzaminu);	
			$czasEgzaminu = $polaczenie->real_escape_string($czasEgzaminu);	
			$wynik = $polaczenie->real_escape_string($wynik);	
		
			$sql = "UPDATE Egzaminy SET DataEgzaminu='$dataEgzaminu', CzasEgzaminu='$czasEgzaminu'";
			if(isset($wynik) && $wynik!="") {
				$sql = $sql.", Wynik='$wynik'";
			}
			else 
			{
				$sql = $sql.", Wynik=NULL";
			}
			$sql = $sql." WHERE ID=$id;";
						
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie']) && $uczenID!=-1 && jestRola('uczen')) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Egzaminy WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	
?>		
		<p>Dodaj wynik z egzaminu, aby pozwolić nam na ocenę zdawalności.</p>
		
		<?php if(jestRola('uczen')) { ?>	
		<form action="egzaminyDodawanie.php" method="post">
			<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
			<input class="btn btn-primary" type="submit" name="DodawanieEgzaminu" value="Dodaj egzamin">
		</form>
		<?php } ?>	
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Data i czas</th>
		<th>Wynik</th>
		<?php if(jestRola('uczen')) { ?>	
		<th>Edycja</th>
		<th>Usuwanie</th>
		<?php }  ?>	
    </tr>
  </thead>
  
  <tbody>
				  <?php
					$polaczenie = polaczZBaza();
					$sql = "SELECT ID, DataEgzaminu, CzasEgzaminu, Wynik FROM Egzaminy where UczenID=$uczenID";
					$result = $polaczenie->query($sql);

					while ($row = $result->fetch_assoc()) {
						$id = $row["ID"];
						$dataEgzaminu = $row["DataEgzaminu"];
						$czasEgzaminu = $row["CzasEgzaminu"];
						$wynik = $row["Wynik"];
				  ?> 
						<tr>
							<td><?php print("$dataEgzaminu $czasEgzaminu"); ?></td>
							<td><?php print("$wynik"); ?></td>
							<?php if(jestRola('uczen')) { ?>	
							<td>
								<form action="egzaminyEdycja.php" method="post">
									<input type="hidden" name="id" value="<?php print("$id"); ?>">
									<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
									<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
								</form>
							</td>
							<td>
								<form action="egzaminy.php" method="post">
									<input type="hidden" name="id" value="<?php print("$id"); ?>">
									<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
									<input class="btn btn-danger" type="submit" name="usuwanie" value="Usuń">
								</form>
							</td>
							<?php }  ?>	
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

	<?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>
</body>
</html>