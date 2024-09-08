<?php
	session_start();
	require("funkcje.php");

	if (isset($_POST['dodawanie']) || isset($_POST['edycja']) || isset($_POST['usuwanie'])) {
		$_SESSION['form_sent'] = true; 
	}

	if (isset($_SESSION['form_sent'])) {
		unset($_SESSION['form_sent']); 
		header("Location: uczniowie.php"); 
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
		<h2 class="pb-2 border-bottom">Uczniowie</h2>

		<?php
		if(isset($_POST['dodawanie'])) {
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$numerTelefonu = $_POST['numerTelefonu'];

			if(poleWymagane('imie') && poleWymagane('nazwisko') && poleWymagane('numerTelefonu')) {
				$polaczenie = polaczZBaza();
				$imie = $polaczenie->real_escape_string($imie);	
				$nazwisko = $polaczenie->real_escape_string($nazwisko);	
				$numerTelefonu = $polaczenie->real_escape_string($numerTelefonu);

				$sql = "INSERT INTO Uczniowie (Imie, Nazwisko, NumerTelefonu) VALUES ('$imie', '$nazwisko', '$numerTelefonu');";
				$polaczenie->query($sql);
				$polaczenie->close();

				header("Location: uczniowie.php?success=1");
				exit();
			}
		} else if(isset($_POST['edycja'])) {
			$id = $_POST['id'];
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$numerTelefonu = $_POST['numerTelefonu'];

			if(poleWymagane('imie') && poleWymagane('nazwisko') && poleWymagane('numerTelefonu')) {
				$polaczenie = polaczZBaza();
				$id = $polaczenie->real_escape_string($id);	
				$imie = $polaczenie->real_escape_string($imie);	
				$nazwisko = $polaczenie->real_escape_string($nazwisko);	
				$numerTelefonu = $polaczenie->real_escape_string($numerTelefonu);

				$sql = "UPDATE Uczniowie SET Imie='$imie', Nazwisko='$nazwisko', NumerTelefonu='$numerTelefonu' WHERE ID=$id;";
				$polaczenie->query($sql);
				$polaczenie->close();

				header("Location: uczniowie.php?success=2");
				exit();
			}
		} else if(isset($_POST['usuwanie'])) {
			$id = $_POST['id'];
			$polaczenie = polaczZBaza();
			$sql = "DELETE FROM Uczniowie WHERE ID = $id;";
			$polaczenie->query($sql);
			$polaczenie->close();

			header("Location: uczniowie.php?success=3");
			exit();
		}
		?>

		<p>Lista uczniów.</p>
		<a href="uczniowieDodawanie.php" class="btn btn-primary" role="button">Dodaj ucznia</a>

		<div class="row g-4 py-5">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Imię</th>
						<th>Nazwisko</th>
						<th>Numer telefonu</th>
						<th>Zakupione pakiety</th>
						<th>Egzaminy</th>
						<th>Edycja</th>
						<th>Usuwanie</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$polaczenie = polaczZBaza();
				$sql = "SELECT ID, Imie, Nazwisko, NumerTelefonu FROM Uczniowie";
				$result = $polaczenie->query($sql);

				while ($row = $result->fetch_assoc()) {
					$id = $row["ID"];
					$imie = $row["Imie"];
					$nazwisko = $row["Nazwisko"];
					$numerTelefonu = $row["NumerTelefonu"];
				?> 
					<tr>
						<td><?php echo $imie; ?></td>
						<td><?php echo $nazwisko; ?></td>
						<td><?php echo $numerTelefonu; ?></td>
						<td>
							<form action="zakupionePakiety.php" method="post">
								<input type="hidden" name="uczenID" value="<?php echo $id; ?>">
								<input class="btn btn-info" type="submit" name="pakiety" value="Zakupione pakiety">
							</form>
						</td>
						<td>
							<form action="egzaminy.php" method="post">
								<input type="hidden" name="uczenID" value="<?php echo $id; ?>">
								<input class="btn btn-info" type="submit" name="egzaminy" value="Egzaminy">
							</form>
						</td>
						<td>
							<form action="uczniowieEdycja.php" method="post">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
							</form>
						</td>
						<td>
							<form action="uczniowie.php" method="post">
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



</body>
<?php displayFooter(); ?>
</html>
