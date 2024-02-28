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
		<h2 class="pb-2 border-bottom">Pakiety lekcji</h2>
	
<?php
		
	if(isset($_POST['dodawanie'])) {
		$nazwaPakietu = $_POST['nazwaPakietu'];
		$iloscLekcji = $_POST['iloscLekcji'];
		$cena = $_POST['cena'];
		$opis = $_POST['opis'];
		
		if(poleWymagane('nazwaPakietu') && poleWymagane('iloscLekcji') && poleWymagane('cena')) {
			$polaczenie = polaczZBaza();
		
			$nazwaPakietu = $polaczenie->real_escape_string($nazwaPakietu);	
			$iloscLekcji = $polaczenie->real_escape_string($iloscLekcji);	
			$cena = $polaczenie->real_escape_string($cena);	
			
			$sql = "INSERT INTO Pakiety (NazwaPakietu, IloscLekcji, Cena) VALUES ('$nazwaPakietu', $iloscLekcji, $cena);";
			if(isset($opis) && $opis!="") {
				$opis = $polaczenie->real_escape_string($opis);	
				$sql = "INSERT INTO Pakiety (NazwaPakietu, IloscLekcji, Cena, Opis) VALUES ('$nazwaPakietu', $iloscLekcji, $cena, '$opis');";
			}

			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['edycja'])) {
		$id = $_POST['id'];
		$nazwaPakietu = $_POST['nazwaPakietu'];
		$iloscLekcji = $_POST['iloscLekcji'];
		$cena = $_POST['cena'];
		$opis = $_POST['opis'];
		
		if(poleWymagane('nazwaPakietu') && poleWymagane('iloscLekcji') && poleWymagane('cena')) {
			$polaczenie = polaczZBaza();
		
			$id = $polaczenie->real_escape_string($id);	
			$nazwaPakietu = $polaczenie->real_escape_string($nazwaPakietu);	
			$iloscLekcji = $polaczenie->real_escape_string($iloscLekcji);	
			$cena = $polaczenie->real_escape_string($cena);	
		
			$sql = "UPDATE Pakiety SET NazwaPakietu='$nazwaPakietu', IloscLekcji='$iloscLekcji', Cena=$cena";
			if(isset($opis) && $opis!="") {
				$sql = $sql.", Opis='$opis'";
			}
			else 
			{
				$sql = $sql.", Opis=NULL";
			}
			$sql = $sql." WHERE ID=$id;";
			
			
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie'])) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Pakiety WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	
?>		
		<p>This is a paragraph.</p>
		<a href="pakietyDodawanie.php" class="btn btn-primary" role="button">Dodaj pakiet</a>
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Nazwa pakietu</th>
		<th>Ilosc lekcji</th>
		<th>Cena</th>
		<th>Opis</th>
		<th>Edycja</th>
		<th>Usuwanie</th>
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();
$sql = "SELECT ID, NazwaPakietu, IloscLekcji, Cena, Opis FROM Pakiety";
$result = $polaczenie->query($sql);

while ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$nazwaPakietu = $row["NazwaPakietu"];
$iloscLekcji = $row["IloscLekcji"];
$cena = $row["Cena"];
$opis = $row["Opis"];
?> 
	<tr>
		<td><?php print("$nazwaPakietu"); ?></td>
		<td><?php print("$iloscLekcji"); ?></td>
		<td><?php print("$cena"); ?></td>
		<td><?php print("$opis"); ?></td>
		<td>
			<form action="pakietyEdycja.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
			</form>
		</td>
		<td>
			<form action="pakiety.php" method="post">
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

<footer class="text-center text-lg-start bg-light text-muted">
  <section class="d-flex justify-content-center p-4 border-bottom">
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Dołącz do nas w mediach społecznościowych:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-google"></i>
      </a>
      <a href="" class="me-4 text-reset">
        <i class="fab fa-instagram"></i>
      </a>
    </div>
    <!-- Right -->
  </section>

  <section class="">
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <!-- Section: Informacje -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Nauka Jazdy
          </h6>
          <p>
            Od 10 lat uczymy jeździć.
          </p>
        </div>
        <!-- Section: Informacje -->

        <!-- Section: Kontakt -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            Kontakt
          </h6>
          <p><i class="fas fa-home me-3"></i> Warszawa, ul. Zdawalnicza 12</p>
          <p><i class="fas fa-envelope me-3"></i> info@naukajazdy.com</p>
          <p><i class="fas fa-phone me-3"></i> + 48 123 456 789</p>
          <p><i class="fas fa-print me-3"></i> + 48 987 654 321</p>
        </div>
        <!-- Section: Kontakt -->

        <!-- Section: Linki -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            Przydatne linki
          </h6>
          <p>
            <a href="#!" class="text-reset">Cennik</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Harmonogram zajęć</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Regulamin</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Polityka prywatności</a>
          </p>
        </div>
        <!-- Section: Linki -->
      </div>
    </div>
  </section>

  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Nauka Jazdy. Wszelkie prawa zastrzeżone.
  </div>
</footer>

  <script src="bootstrap.bundle.min.js"></script>

</body>
</html>