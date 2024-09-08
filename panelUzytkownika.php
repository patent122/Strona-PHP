<?php
	session_start();
	require("funkcje.php");

	if (isset($_POST['resetHasla'])) {
		if (poleWymagane('haslo') && poleWymagane('haslo2') && powtorzenieHasla('haslo', 'haslo2')) {
			$id = $_POST['id'];
			$haslo = $_POST['haslo'];
			$polaczenie = polaczZBaza();
			$hasloHaszowane = password_hash($haslo, PASSWORD_DEFAULT);
			$sql = "UPDATE Uzytkownicy SET Haslo='$hasloHaszowane' WHERE ID=$id;";
			$polaczenie->query($sql);
			$polaczenie->close();

			$_SESSION['form_sent'] = true;
			header("Location: panelUzytkownika.php?success=1");
			exit();
		}
	}

	if (isset($_SESSION['form_sent'])) {
		unset($_SESSION['form_sent']); 
		header("Location: panelUzytkownika.php");
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
	
	<h2 class="pb-2 border-bottom">Panel użytkownika</h2>
	
	<?php
	if (isset($_GET['success']) && $_GET['success'] == 1) {
		echo '<div class="alert alert-success">Hasło zostało pomyślnie zmienione!</div>';
	}
	?>		

	<p>Twoje konto.</p>
	<div class="row g-4 py-5">
		
		<table class="table table-striped table-hover">
		  <thead>
			<tr>
				<th>Imię</th>
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
				<td><?php echo $imie; ?></td>
				<td><?php echo $nazwisko; ?></td>
				<td><?php echo $login; ?></td>
				<td><?php echo $numerTelefonu; ?></td>
				<td><?php echo $rola; ?></td>
				
				<td>
					<form action="uzytkownicyResetHasla.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
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



</body>
<?php displayFooter(); ?>
</html>
