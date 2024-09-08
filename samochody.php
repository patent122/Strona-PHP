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
	
	<?php menu(); ?>

	<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Samochody</h2>

		<?php
		if(isset($_POST['dodawanie'])) {
			$marka = $_POST['marka'];
			$model = $_POST['model'];
			$rokProdukjci = $_POST['rokProdukjci'];

			if(poleWymagane('marka') && poleWymagane('model') && poleWymagane('rokProdukjci')) {
				$polaczenie = polaczZBaza();
				$marka = $polaczenie->real_escape_string($marka);	
				$model = $polaczenie->real_escape_string($model);	
				$rokProdukjci = $polaczenie->real_escape_string($rokProdukjci);	

				$sql = "INSERT INTO Samochody (Marka, Model, RokProdukcji) VALUES ('$marka', '$model', $rokProdukjci);";
				$polaczenie->query($sql);
				$polaczenie->close();

				header("Location: samochody.php?success=1");
				exit();
			}
		} else if(isset($_POST['edycja'])) {
			$id = $_POST['id'];
			$marka = $_POST['marka'];
			$model = $_POST['model'];
			$rokProdukjci = $_POST['rokProdukjci'];

			if(poleWymagane('marka') && poleWymagane('model') && poleWymagane('rokProdukjci')) {
				$polaczenie = polaczZBaza();
				$id = $polaczenie->real_escape_string($id);	
				$marka = $polaczenie->real_escape_string($marka);	
				$model = $polaczenie->real_escape_string($model);	
				$rokProdukjci = $polaczenie->real_escape_string($rokProdukjci);	

				$sql = "UPDATE Samochody SET Marka='$marka', Model='$model', RokProdukcji=$rokProdukjci WHERE ID=$id;";
				$polaczenie->query($sql);
				$polaczenie->close();
				
				header("Location: samochody.php?success=2");
				exit();
			}
		} else if(isset($_POST['usuwanie'])) {
			$id = $_POST['id'];
			$polaczenie = polaczZBaza();
			$sql = "DELETE FROM Samochody WHERE ID = $id;";
			$polaczenie->query($sql);
			$polaczenie->close();

			header("Location: samochody.php?success=3");
			exit();
		}
		?>

		<p>Lista samochodów na stanie szkoły.</p>

		<?php
		if (isset($_GET['success'])) {
			if ($_GET['success'] == 1) {
				echo '<div class="alert alert-success">Samochód został pomyślnie dodany!</div>';
			} else if ($_GET['success'] == 2) {
				echo '<div class="alert alert-success">Samochód został pomyślnie zaktualizowany!</div>';
			} else if ($_GET['success'] == 3) {
				echo '<div class="alert alert-success">Samochód został pomyślnie usunięty!</div>';
			}
		}
		?>

		<a href="samochodyDodawanie.php" class="btn btn-primary" role="button">Dodaj samochód</a>

		<div class="row g-4 py-5">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Marka</th>
						<th>Model</th>
						<th>Rok produkcji</th>
						<th>Edycja</th>
						<th>Usuwanie</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$polaczenie = polaczZBaza();
				$sql = "SELECT ID, Marka, Model, RokProdukcji FROM Samochody";
				$result = $polaczenie->query($sql);

				while ($row = $result->fetch_assoc()) {
					$id = $row["ID"];
					$marka = $row["Marka"];
					$model = $row["Model"];
					$rokProdukcji = $row["RokProdukcji"];
					?>
					<tr>
						<td><?php echo $marka; ?></td>
						<td><?php echo $model; ?></td>
						<td><?php echo $rokProdukcji; ?></td>
						<td>
							<form action="samochodyEdycja.php" method="post">
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
							</form>
						</td>
						<td>
							<form action="samochody.php" method="post">
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
