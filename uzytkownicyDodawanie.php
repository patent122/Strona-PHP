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
		<h2 class="pb-2 border-bottom">Dodawanie uzytkownika</h2>
		<div class="row g-4 py-5">
		
			<form action="uzytkownicy.php" method="post">
				<div class="form-group">
					<label for="imie">Imie</label>
					<input type="text" class="form-control" id="imie" name="imie" placeholder="imie">
				</div>
				<div class="form-group">
					<label for="nazwisko">Nazwisko</label>
					<input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="nazwisko">
				</div>
				<div class="form-group">
					<label for="login">Login</label>
					<input type="text" class="form-control" id="login" name="login" placeholder="login">
				</div>
				<div class="form-group">
					<label for="numerTelefonu">Numer telefonu</label>
					<input type="tel" class="form-control" id="numerTelefonu" name="numerTelefonu" minlength="9" maxlength="9" pattern="[0-9]{1,9}" placeholder="telefon" required>
				</div>
				<div class="form-group">
    <label for="instruktor">Rola:</label><br>
    <select id="rola" name="rola">
        <?php if (jestRola('administrator')): ?>
            <option value="administrator">administrator</option>
            <option value="koordynator">koordynator</option>
            <option value="instruktor">instruktor</option>
        <?php endif; ?>
        <option value="uczen">uczeń</option>
    </select>
</div>
				<div class="form-group">
					<label for="login">hasło</label>
					<input type="password" class="form-control" id="haslo" minlength="5" name="haslo" placeholder="hasło">
				</div>
				<div class="form-group">
					<label for="login">powtorz hasło</label>
					<input type="password" class="form-control" id="haslo2" minlength="5" name="haslo2" placeholder="powtorzone hasło">
				</div>
				<br>
				<input class="btn btn-primary" type="submit" name="dodawanie" value="Dodaj uzytkownika">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>