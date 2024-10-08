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
		<h2 class="pb-2 border-bottom">Edycja samochodu</h2>
		<div class="row g-4 py-5">
		
		<?php
		
$id = $_POST['id'];
$polaczenie = polaczZBaza();
		
$sql = "SELECT Marka, Model, RokProdukcji FROM Samochody WHERE ID=$id;";
$result = $polaczenie->query($sql);

$row = $result->fetch_assoc();
	
$marka = $row["Marka"];
$model = $row["Model"];
$rokProdukcji = $row["RokProdukcji"];
		
		?>
			<form action="samochody.php" method="post">
				<div class="form-group">
					<label for="marka">Marka</label>
					<input type="text" class="form-control" id="marka" name="marka" value="<?php print($marka); ?>" placeholder="marka samochodu">
				</div>
				<div class="form-group">
					<label for="model">Model</label>
					<input type="text" class="form-control" id="model" name="model" value="<?php print($model); ?>" placeholder="model samochodu">
				</div>
				<div class="form-group">
					<label for="rokProdukjci">Rok produkcji</label>
					<input type="number" class="form-control" id="rokProdukjci" name="rokProdukjci" value="<?php print($rokProdukcji); ?>" placeholder="2024">
				</div>
				<input type="hidden" name="id" value="<?php print($id); ?>">
				<br>
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj samochod">
			</form>
		
		</div>
	</div>
	
	
</main>

  <?php displayFooter(); ?>


</body>
</html>