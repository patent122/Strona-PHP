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
		<h2 class="pb-2 border-bottom">Edycja ucznia</h2>
		<div class="row g-4 py-5">
		
		<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT Imie, Nazwisko, NumerTelefonu FROM Uczniowie WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$numerTelefonu = $row["NumerTelefonu"];
		
		?>
			<form action="uczniowie.php" method="post">
				<div class="form-group">
					<label for="imie">Imie</label>
					<input type="text" class="form-control" id="imie" name="imie" value="<?php print($imie); ?>" placeholder="imie ucznia">
				</div>
				<div class="form-group">
					<label for="nazwisko">Nazwisko</label>
					<input type="text" class="form-control" id="nazwisko" name="nazwisko" value="<?php print($nazwisko); ?>" placeholder="model ucznia">
				</div>
				<div class="form-group">
					<label for="numerTelefonu">Numer telefonu</label>
					<input type="text" class="form-control" id="numerTelefonu" name="numerTelefonu" value="<?php print($numerTelefonu); ?>" placeholder="2024">
				</div>
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj ucznia">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>