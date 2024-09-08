<?php
	session_start();
	require("funkcje.php");

	if(isset($_POST['dodawanie'])) {
		$nazwaPakietu = $_POST['nazwaPakietu'];
		$iloscLekcji = $_POST['iloscLekcji'];
		$cena = $_POST['cena'];
		$opis = $_POST['opis'];

		if(poleWymagane('nazwaPakietu') && poleWymagane('iloscLekcji') && poleWymagane('cena')) {
			$polaczenie = polaczZBaza();
			$nazwaPakietu = $polaczenie->real_escape_string($nazwaPakietu);	
			$iloscLekcji = $polaczenie->real_escape_string($iloscLekcji);	
			$cena = $polaczenie->real_escape_string($cena);

			$sql = "INSERT INTO Pakiety (NazwaPakietu, IloscLekcji, Cena) VALUES ('$nazwaPakietu', $iloscLekcji, $cena);";
			if(isset($opis) && $opis!="") {
				$opis = $polaczenie->real_escape_string($opis);	
				$sql = "INSERT INTO Pakiety (NazwaPakietu, IloscLekcji, Cena, Opis) VALUES ('$nazwaPakietu', $iloscLekcji, $cena, '$opis');";
			}

			$polaczenie->query($sql);
			$polaczenie->close();

			$_SESSION['form_sent'] = true;
			header("Location: pakiety.php?success=1");
			exit();
		}
	} else if(isset($_POST['edycja'])) {
		$id = $_POST['id'];
		$nazwaPakietu = $_POST['nazwaPakietu'];
		$iloscLekcji = $_POST['iloscLekcji'];
		$cena = $_POST['cena'];
		$opis = $_POST['opis'];

		if(poleWymagane('nazwaPakietu') && poleWymagane('iloscLekcji') && poleWymagane('cena')) {
			$polaczenie = polaczZBaza();
			$id = $polaczenie->real_escape_string($id);	
			$nazwaPakietu = $polaczenie->real_escape_string($nazwaPakietu);	
			$iloscLekcji = $polaczenie->real_escape_string($iloscLekcji);	
			$cena = $polaczenie->real_escape_string($cena);

			$sql = "UPDATE Pakiety SET NazwaPakietu='$nazwaPakietu', IloscLekcji='$iloscLekcji', Cena=$cena";
			if(isset($opis) && $opis!="") {
				$sql = $sql.", Opis='$opis'";
			} else {
				$sql = $sql.", Opis=NULL";
			}
			$sql = $sql." WHERE ID=$id;";

			$polaczenie->query($sql);
			$polaczenie->close();

			$_SESSION['form_sent'] = true;
			header("Location: pakiety.php?success=2");
			exit();
		}
	} else if(isset($_POST['usuwanie'])) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Pakiety WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();

		$_SESSION['form_sent'] = true;
		header("Location: pakiety.php?success=3");
		exit();
	}

	if (isset($_SESSION['form_sent'])) {
		unset($_SESSION['form_sent']); 
		header("Location: pakiety.php");
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
  </head>

<body>
	<main>
	
	<?php menu(); ?>

	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Pakiety lekcji</h2>

		<p>Oferowane przez szkołę pakiety do wykupienia.</p>

		<?php
		if (isset($_GET['success'])) {
			if ($_GET['success'] == 1) {
				echo '<div class="alert alert-success">Pakiet został pomyślnie dodany!</div>';
			} else if ($_GET['success'] == 2) {
				echo '<div class="alert alert-success">Pakiet został pomyślnie zaktualizowany!</div>';
			} else if ($_GET['success'] == 3) {
				echo '<div class="alert alert-success">Pakiet został pomyślnie usunięty!</div>';
			}
		}
		?>

		<a href="pakietyDodawanie.php" class="btn btn-primary" role="button">Dodaj pakiet</a>

		<div class="row g-4 py-5">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Nazwa pakietu</th>
						<th>Ilość lekcji</th>
						<th>Cena</th>
						<th>Opis</th>
						<th>Edycja</th>
						<th>Usuwanie</th>
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
						<td><?php echo $nazwaPakietu; ?></td>
						<td><?php echo $iloscLekcji; ?></td>
						<td><?php echo $cena; ?></td>
						<td><?php echo $opis; ?></td>
						<td>
							<form action="pakietyEdycja.php" method="post">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
							</form>
						</td>
						<td>
							<form action="pakiety.php" method="post">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input class="btn btn-danger" type="submit" name="usuwanie" value="Usuń">
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

<?php displayFooter(); ?>

</body>
</html>
