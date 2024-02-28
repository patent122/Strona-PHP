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
	
<?php menu(); 

	$uczenID = -1;
	$pakietID = -1;
	$imie = "";
	$nazwisko = "";
	$nazwaPakietu = "";
	
	if(isset($_POST['uczenID']))
	{
		$uczenID = $_POST['uczenID'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID = $uczenID";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
		}
		
		$pakietID = $_POST['pakietID'];
		$sql = "SELECT P.NazwaPakietu FROM ZakupionePakiety ZP JOIN Pakiety P ON ZP.PakietID = P.ID WHERE ZP.ID = $pakietID;";
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$nazwaPakietu = $row["NazwaPakietu"];
		}
		
		$polaczenie->close();
	}
?>

<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Lekcje dla ucznia: <?php print("$imie $nazwisko"); ?></h2>
		<h3 class="pb-3 border-bottom">Lekcje do pakietu: <?php print("$nazwaPakietu"); ?></h3>
		
	
<?php
	if(isset($_POST['dodawanie']) && $uczenID!=-1 && $pakietID!=-1 && jestRola('instruktor')) {
		
		if(poleWymagane('dataICzasLekcji') && poleWymagane('samochod')) {
			
			$dataICzasLekcji = $_POST['dataICzasLekcji'];
			$instruktorID = $_SESSION['userId'];
			$samochodID = $_POST['samochod'];
			
			$polaczenie = polaczZBaza();
			
			$dataLekcji="";
			$czasLekcji="";
			list($dataLekcji, $czasLekcji) = explode('T', $dataICzasLekcji);

			$dataLekcji = $polaczenie->real_escape_string($dataLekcji);	
			$czasLekcji = $polaczenie->real_escape_string($czasLekcji);	
		
			$sql = "INSERT INTO Lekcje (DataLekcji, CzasLekcji, InstruktorID, ZakupionyPakietID, SamochodID) VALUES ('$dataLekcji', '$czasLekcji', $instruktorID, $pakietID, $samochodID);";
			
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['edycja']) && $uczenID!=-1 && $pakietID!=-1 && jestRola('instruktor')) {
		
		if(poleWymagane('dataICzasLekcji') && poleWymagane('samochod')) {
			$id = $_POST['id'];
			$dataICzasLekcji = $_POST['dataICzasLekcji'];
			$instruktorID = $_SESSION['userId'];
			$samochodID = $_POST['samochod'];
			
			$polaczenie = polaczZBaza();
		
			$dataLekcji="";
			$czasLekcji="";
			list($dataLekcji, $czasLekcji) = explode('T', $dataICzasLekcji);

			$dataLekcji = $polaczenie->real_escape_string($dataLekcji);	
			$czasLekcji = $polaczenie->real_escape_string($czasLekcji);	
			
			$sql = "UPDATE Lekcje SET DataLekcji='$dataLekcji', CzasLekcji='$czasLekcji', InstruktorID=$instruktorID, SamochodID=$samochodID WHERE ID=$id;";
						
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie']) && $uczenID!=-1 && jestRola('instruktor')) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Lekcje WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	
?>		
		<p>This is a paragraph.</p>
		<?php if(jestRola('instruktor')) { ?>
		<form action="lekcjeDodawanie.php" method="post">
			<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
			<input type="hidden" name="pakietID" value="<?php print("$pakietID"); ?>">
			<input class="btn btn-primary" type="submit" name="DodawanieEgzaminu" value="Dodaj lekcje">
		</form>
		<br>
		<?php } ?>
		<form action="zakupionePakiety.php" method="post">
			<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
			<input class="btn btn-primary" type="submit" name="DodawanieEgzaminu" value="Zakupione pakiety ucznia">
		</form>
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Data i czas</th>
		<th>Instruktor</th>
		<th>Samochod</th>
		<?php if(jestRola('instruktor')) { ?>
		<th>Edycja</th>
		<th>Usuwanie</th>
		<?php } ?>
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();

$sql = "SELECT L.ID, L.DataLekcji, L.CzasLekcji, I.Imie, I.Nazwisko,I.Id as 'instruktorID', S.Marka,S.Model,S.RokProdukcji
		FROM Lekcje L
			JOIN Uzytkownicy I ON L.InstruktorID = I.ID
			JOIN Samochody S ON L.SamochodID = S.ID
		WHERE ZakupionyPakietID =$pakietID";
$result = $polaczenie->query($sql);


while ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$dataEgzaminu = $row["DataLekcji"];
$czasEgzaminu = $row["CzasLekcji"];
$imie = $row["Imie"];
$nazwisko = $row["Nazwisko"];
$marka = $row["Marka"];
$model = $row["Model"];
$rokProdukcji = $row["RokProdukcji"];
$instruktorID = $row["instruktorID"];
?> 
	<tr>
		<td><?php print("$dataEgzaminu $czasEgzaminu"); ?></td>
		<td><?php print("$imie $nazwisko"); ?></td>
		<td><?php print("$marka $model ($rokProdukcji r.)"); ?></td>
		<?php if(jestRola('instruktor')) { 
				$userId = $_SESSION['userId'];
		?>
		<td>
			<?php if($userId==$instruktorID) { ?>
			<form action="lekcjeEdycja.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input type="hidden" name="pakietID" value="<?php print("$pakietID"); ?>">
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
			</form>
			<?php } ?>
		</td>
		<td>
			<?php if($userId==$instruktorID) { ?>
			<form action="lekcje.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input type="hidden" name="pakietID" value="<?php print("$pakietID"); ?>">
				<input class="btn btn-danger" type="submit" name="usuwanie" value="Usun">
			</form>
			<?php } ?>
		</td>
		<?php } ?>
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