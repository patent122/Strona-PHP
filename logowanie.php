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
	<?php 
	$komunikat = "";
	if(isset($_POST['zaloguj'])) {
		if(poleWymagane('login') && poleWymagane('haslo')) {
		
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$polaczenie = polaczZBaza();
			$login = $polaczenie->real_escape_string($login);	
			$haslo = $polaczenie->real_escape_string($haslo);	
			
			$sql = "SELECT Id, Imie, Nazwisko, Login,Haslo, Rola FROM Uzytkownicy WHERE Login='$login';";
			$result = $polaczenie->query($sql);

			if($row = $result->fetch_assoc())
			{
				$id = $row["Id"];
				$imie = $row["Imie"];
				$nazwisko = $row["Nazwisko"];
				$login = $row["Login"];
				$rola = $row["Rola"];
				$hasloBaza = $row['Haslo'];

				if(password_verify($haslo, $hasloBaza))
				{
						
					$_SESSION['user'] = $login;
					$_SESSION['userId'] = $id;
					$_SESSION['rola'] = $rola;
				
					$komunikat = "<p>Witaj $imie $nazwisko rola: $rola</p>";
				}
				else {
				$komunikat ='Nieprawidłowe dane logowania<br>';
				}
				
			}		
			else
			{
				 $komunikat ='Nieprawidłowe dane logowania<br>';
			}
		}
	}
	else if(isset($_POST['wyloguj'])) {
		$_SESSION['user'] = null;
	}
	
	
	
	menu(); ?>

<div class="container px-1 py-5">
	<h2 class="pb-2 border-bottom">Logowanie</h2>

	<p>Logowanie do systemu nauki jazdy</p>
	<div class="row g-4 py-5">
	
<?php 
	print($komunikat);
if(zalogowany()) { 
?>
			<form action="logowanie.php" method="post">
				<input class="btn btn-danger" type="submit" name="wyloguj" value="Wyloguj sie">
			</form>
			
<?php  
		}
		else { 
?>
			<form action="logowanie.php" method="post">
				<div class="form-group">
					<label for="imie">Login</label>
					<input type="text" class="form-control" id="login" name="login" placeholder="login">
				</div>
				<div class="form-group">
					<label for="imie">Haslo</label>
					<input type="password" class="form-control" id="haslo" name="haslo" placeholder="hasło">
				</div>
				<br>
				<input class="btn btn-primary" type="submit" name="zaloguj" value="Zaloguj sie">
			</form>
			

<?php  } ?>
	</div>
</div>
	

	
</main>

  <?php displayFooter(); ?>


</body>
</html>