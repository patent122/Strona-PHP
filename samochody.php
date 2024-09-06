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

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/navbars/">
    
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

    
    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">
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
		}
	}
	else if(isset($_POST['edycja'])) {
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
		}
	}
	else if(isset($_POST['usuwanie'])) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Samochody WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	
?>		
		<p>Lista samochodów na stanie szkoły.</p>
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
		<td><?php print("$marka"); ?></td>
		<td><?php print("$model"); ?></td>
		<td><?php print("$rokProdukcji"); ?></td>
		<td>
			<form action="samochodyEdycja.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
			</form>
		</td>
		<td>
			<form action="samochody.php" method="post">
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
 <script src="bootstrap.bundle.min.js"></script>

  <?php displayFooter(); ?>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>