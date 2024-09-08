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
		<h2 class="pb-2 border-bottom">Edycja pakietu</h2>
		<div class="row g-4 py-5">
		
		<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT NazwaPakietu, IloscLekcji, Cena, Opis FROM Pakiety WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$nazwaPakietu = $row["NazwaPakietu"];
$iloscLekcji = $row["IloscLekcji"];
$cena = $row["Cena"];
$opis = $row["Opis"];
		
		?>
			<form action="pakiety.php" method="post">
				<div class="form-group">
					<label for="nazwaPakietu">Nazwa pakietu</label>
					<input type="text" class="form-control" id="nazwaPakietu" name="nazwaPakietu" value="<?php print($nazwaPakietu); ?>" placeholder="nazwa">
				</div>
				<div class="form-group">
					<label for="iloscLekcji">Ilosc lekcji</label>
					<input type="number" class="form-control" id="iloscLekcji" name="iloscLekcji" value="<?php print($iloscLekcji); ?>" placeholder="ilość lekcji">
				</div>
				<div class="form-group">
					<label for="cena">Cena</label>
					<input type="number" class="form-control" id="cena" name="cena" value="<?php print($cena); ?>" placeholder="cena">
				</div>
				<div class="form-group">
					<label for="opis">Opis</label>
					<input type="text" class="form-control" id="opis" name="opis" value="<?php print($opis); ?>" placeholder="opis">
				</div>
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj pakiet">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>