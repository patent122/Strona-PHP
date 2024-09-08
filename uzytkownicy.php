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
	
	<?php menu(); ?>

<div class="container px-1 py-5">
	<?php if(jestRola('administrator')) {?>
		<h2 class="pb-2 border-bottom">Uzytkownicy</h2>
	<?php } else if(jestRola('instruktor')) { ?>	
		<h2 class="pb-2 border-bottom">Uczniowe</h2>
	<?php } ?>	
<?php
		
	if (isset($_POST['dodawanie'])) {
        if (poleWymagane('imie') && poleWymagane('nazwisko') && poleWymagane('numerTelefonu')
            && poleWymagane('login') && poleWymagane('rola')
            && poleWymagane('haslo') && poleWymagane('haslo2')
            && powtorzenieHasla('haslo', 'haslo2')
        ) {
            $imie = $_POST['imie'];
            $nazwisko = $_POST['nazwisko'];
            $numerTelefonu = $_POST['numerTelefonu'];
            $login = $_POST['login'];
            $rola = $_POST['rola'];
            $haslo = $_POST['haslo'];
            $haslo2 = $_POST['haslo2'];

            $polaczenie = polaczZBaza();

            $sql = "SELECT * FROM Uzytkownicy WHERE Login = '$login' OR NumerTelefonu = '$numerTelefonu'";
			$wynik = $polaczenie->query($sql);

			if ($wynik->num_rows > 0) {
    			echo '<p style="color: red;">Taki login lub numer telefonu już istnieje w bazie danych.</p>';
			} else {
                $imie = $polaczenie->real_escape_string($imie);
                $nazwisko = $polaczenie->real_escape_string($nazwisko);
                $numerTelefonu = $polaczenie->real_escape_string($numerTelefonu);
                $rola = $polaczenie->real_escape_string($rola);
                $login = $polaczenie->real_escape_string($login);
                $haslo = $polaczenie->real_escape_string($haslo);
                $hasloHaszowane = password_hash($haslo, PASSWORD_DEFAULT);

                $sql = "INSERT INTO Uzytkownicy (Imie, Nazwisko, NumerTelefonu, Login, Rola, Haslo) VALUES 
                        ('$imie', '$nazwisko', '$numerTelefonu', '$login', '$rola', '$hasloHaszowane');";
                if ($polaczenie->query($sql) === TRUE) {
                    echo '<p style="color: green;">Nowy użytkownik został dodany.</p>';
                } else {
                    echo '<p style="color: red;">Wystąpił błąd podczas dodawania użytkownika: ' . $polaczenie->error . '</p>';
                }
            }

            $polaczenie->close();
		}
	}
	else if(isset($_POST['edycja'])) {
		$id = $_POST['id'];
		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$login = $_POST['login'];
		$numerTelefonu = $_POST['numerTelefonu'];
		$rola = $_POST['rola'];
		
		
		if(poleWymagane('imie') && poleWymagane('nazwisko') && poleWymagane('numerTelefonu')) {
			$polaczenie = polaczZBaza();
		
			$id = $polaczenie->real_escape_string($id);	
			$imie = $polaczenie->real_escape_string($imie);	
			$nazwisko = $polaczenie->real_escape_string($nazwisko);	
			$login = $polaczenie->real_escape_string($login);	
			$numerTelefonu = $polaczenie->real_escape_string($numerTelefonu);	
			$rola = $polaczenie->real_escape_string($rola);	
		
			$sql = "SELECT * FROM Uzytkownicy WHERE (Login = '$login' OR NumerTelefonu = '$numerTelefonu') AND ID != $id";
			$wynik = $polaczenie->query($sql);
		
			if ($wynik->num_rows > 0) {
				echo '<p style="color: red;">Taki login lub numer telefonu już istnieje w bazie danych.</p>';
			} else {
				$sql = "UPDATE Uzytkownicy SET Imie='$imie', Nazwisko='$nazwisko', Login='$login', NumerTelefonu='$numerTelefonu', Rola='$rola' WHERE ID=$id;";
				if ($polaczenie->query($sql) === TRUE) {
					echo '<p style="color: green;">Dane użytkownika zostały zaktualizowane.</p>';
				} else {
					echo '<p style="color: red;">Wystąpił błąd podczas edytowania użytkownika: ' . $polaczenie->error . '</p>';
				}
			}
		
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie'])) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Uzytkownicy WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	else if(isset($_POST['resetHasla'])) {
		
		if(poleWymagane('haslo') && poleWymagane('haslo2') && powtorzenieHasla('haslo', 'haslo2'))
		{
			$id = $_POST['id'];
			$haslo = $_POST['haslo'];
			$haslo2 = $_POST['haslo2'];
			$polaczenie = polaczZBaza();
			$hasloHaszowane = password_hash($haslo, PASSWORD_DEFAULT);
			$sql = "UPDATE Uzytkownicy SET Haslo='$hasloHaszowane' WHERE ID=$id;";
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	
	
?>		
		<p>Lista uczniów.</p>
		<a href="uzytkownicyDodawanie.php" class="btn btn-primary" role="button">Dodaj uzytkownika</a>
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Imie</th>
		<th>Nazwisko</th>
		<th>Login</th>
		<th>Numer telefonu</th>
		<?php if(jestRola('administrator')) {?>
		<th>Rola</th>
		<?php } else if(jestRola('instruktor')) {?>
		<th>Zakupione pakiety</th>
		<th>Egzaminy</th>
		<?php } ?>
		
		<th>Edycja</th>
		<th>Reset hasła</th>
		<th>Usuwanie</th>
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();
$sql = "";
if(jestRola('administrator')) {
	$sql = "SELECT ID, Imie, Nazwisko, Login, Rola, NumerTelefonu FROM Uzytkownicy";
} else if(jestRola('instruktor')) {
	$sql = "SELECT ID, Imie, Nazwisko, Login, Rola, NumerTelefonu FROM Uzytkownicy WHERE Rola='uczen'";
}

$result = $polaczenie->query($sql);

while ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$login = $row["Login"];
$rola = $row["Rola"];
$numerTelefonu = $row["NumerTelefonu"];
?> 
	<tr>
		<td><?php print("$imie"); ?></td>
		<td><?php print("$nazwisko"); ?></td>
		<td><?php print("$login"); ?></td>
		<td><?php print("$numerTelefonu"); ?></td>
		<?php if(jestRola('administrator')) {?>
		<td><?php print("$rola"); ?></td>
		<?php } ?>
		
		<?php if(jestRola('instruktor')) {?>
		<td>
			<form action="zakupionePakiety.php" method="post">
				<input type="hidden" name="uczenID" value="<?php print("$id"); ?>">
				<input class="btn btn-info" type="submit" name="pakiety" value="Zakupione pakiety">
			</form>
		</td>
		<td>
			<form action="egzaminy.php" method="post">
				<input type="hidden" name="uczenID" value="<?php print("$id"); ?>">
				<input class="btn btn-info" type="submit" name="egzaminy" value="Egzaminy">
			</form>
		</td>
		<?php } ?>
		
		<td>
			<form action="uzytkownicyEdycja.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
			</form>
		</td>
		<td>
			<form action="uzytkownicyResetHasla.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input class="btn btn-success" type="submit" name="resetHasla" value="Resetuj hasło">
			</form>
		</td>
		<td>
			<form action="uzytkownicy.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input class="btn btn-danger" type="submit" name="usuwanie" value="Usun">
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