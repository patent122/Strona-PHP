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
		<h2 class="pb-2 border-bottom">Edycja uzytkownika</h2>
		<div class="row g-4 py-5">
		
		<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT Imie, Nazwisko, Login, Rola, NumerTelefonu FROM Uzytkownicy WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$login = $row["Login"];
$rola = $row["Rola"];
$numerTelefonu = $row["NumerTelefonu"];
		
		?>
		<form action="uzytkownicy.php" method="post">
    <div class="form-group">
        <label for="imie">Imię</label>
        <input type="text" class="form-control" id="imie" name="imie" pattern="[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+" value="<?php echo htmlspecialchars($imie); ?>" placeholder="Imię instruktora" required>
    </div>
    <div class="form-group">
        <label for="nazwisko">Nazwisko</label>
        <input type="text" class="form-control" id="nazwisko" name="nazwisko" pattern="[A-Za-zĄĆĘŁŃÓŚŹŻąćęłńóśźż]+" value="<?php echo htmlspecialchars($nazwisko); ?>" placeholder="Nazwisko instruktora" required>
    </div>
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" class="form-control" id="login" name="login" value="<?php echo htmlspecialchars($login); ?>" placeholder="Login" required>
    </div>
    <div class="form-group">
        <label for="numerTelefonu">Numer telefonu</label>
        <input type="tel" class="form-control" id="numerTelefonu" name="numerTelefonu" minlength="9" maxlength="9" pattern="[0-9]{9}" value="<?php echo htmlspecialchars($numerTelefonu); ?>" placeholder="Numer telefonu" required>
    </div>
				<div class="form-group">
					<label for="instruktor">Rola:</label><br>
					<?php if(jestRola('administrator')) {?>
					<select id="rola" name="rola">
						<option value="administrator"  <?php wybranaRola($rola, "administrator"); ?> >administrator</option>
						<option value="uczen" <?php wybranaRola($rola, "uczen"); ?> >uczeń</option>
						<option value="instruktor" <?php wybranaRola($rola, "instruktor"); ?> >instruktor</option>
					</select>
					<?php } else if(jestRola('instruktor')) {?>
					<select id="rola" name="rola">
						<option value="uczen" <?php wybranaRola($rola, "uczen"); ?> >uczeń</option>
					</select>
					<?php } ?>
				</div>
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj uzytkownika">
			</form>
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>