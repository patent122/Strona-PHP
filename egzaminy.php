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
	$imie = "";
	$nazwisko = "";
	if(jestRola('uczen'))
	//if(isset($_POST['uczenID']))
	{
		//$uczenID = $_POST['uczenID'];
		$uczenID = $_SESSION['userId'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID = $uczenID";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
		}
		$polaczenie->close();
	}
	else if(jestRola('instruktor')) {
		$uczenID = $_POST['uczenID'];
		$sql = "SELECT Imie, Nazwisko FROM Uzytkownicy WHERE ID = $uczenID";
		$polaczenie = polaczZBaza();
		$result = $polaczenie->query($sql);
		if ($row = $result->fetch_assoc()) {
			$imie = $row["Imie"];
			$nazwisko = $row["Nazwisko"];
		}
		$polaczenie->close();
	}
?>

<div class="container px-1 py-5">
		<h2 class="pb-2 border-bottom">Egzaminy ucznia: <?php print("$imie $nazwisko"); ?></h2>
	
<?php
	//error_reporting(E_ERROR | E_WARNING | E_PARSE);
	// lub
	//ini_set('display_errors', '0');
	
	
	
	if(isset($_POST['dodawanie']) && $uczenID!=-1 && jestRola('uczen')) {
		
		$dataICzasEgzaminu = $_POST['dataICzasEgzaminu'];

		
		$wynik = $_POST['wynik'];
		
		if(poleWymagane('dataICzasEgzaminu')) {
			$polaczenie = polaczZBaza();
			
			$dataEgzaminu="";
			$czasEgzaminu="";
			list($dataEgzaminu, $czasEgzaminu) = explode('T', $dataICzasEgzaminu);

			$dataEgzaminu = $polaczenie->real_escape_string($dataEgzaminu);	
			$czasEgzaminu = $polaczenie->real_escape_string($czasEgzaminu);	
			$wynik = $polaczenie->real_escape_string($wynik);	
		
			$sql = "INSERT INTO Egzaminy (DataEgzaminu, CzasEgzaminu, UczenID) VALUES ('$dataEgzaminu', '$czasEgzaminu', $uczenID);";
			if(isset($wynik) && $wynik!="") {
				$wynik = $polaczenie->real_escape_string($wynik);	
				$sql = "INSERT INTO Egzaminy (DataEgzaminu, CzasEgzaminu, UczenID, Wynik) VALUES ('$dataEgzaminu', '$czasEgzaminu', $uczenID, '$wynik');";
			}
			
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['edycja']) && $uczenID!=-1 && jestRola('uczen')) {
		$id = $_POST['id'];
		$dataICzasEgzaminu = $_POST['dataICzasEgzaminu'];
		
		$wynik = $_POST['wynik'];
		
		if(poleWymagane('dataICzasEgzaminu')) {
			$polaczenie = polaczZBaza();
		
			$id = $polaczenie->real_escape_string($id);	
			$dataEgzaminu="";
			$czasEgzaminu="";
			list($dataEgzaminu, $czasEgzaminu) = explode('T', $dataICzasEgzaminu);

			$dataEgzaminu = $polaczenie->real_escape_string($dataEgzaminu);	
			$czasEgzaminu = $polaczenie->real_escape_string($czasEgzaminu);	
			$wynik = $polaczenie->real_escape_string($wynik);	
		
			$sql = "UPDATE Egzaminy SET DataEgzaminu='$dataEgzaminu', CzasEgzaminu='$czasEgzaminu'";
			if(isset($wynik) && $wynik!="") {
				$sql = $sql.", Wynik='$wynik'";
			}
			else 
			{
				$sql = $sql.", Wynik=NULL";
			}
			$sql = $sql." WHERE ID=$id;";
						
			$polaczenie->query($sql);
			$polaczenie->close();
		}
	}
	else if(isset($_POST['usuwanie']) && $uczenID!=-1 && jestRola('uczen')) {
		$id = $_POST['id'];
		$polaczenie = polaczZBaza();
		$sql = "DELETE FROM Egzaminy WHERE ID = $id;";
		$polaczenie->query($sql);
		$polaczenie->close();
	}
	
?>		
		<p>This is a paragraph.</p>
		
		<?php if(jestRola('uczen')) { ?>	
		<form action="egzaminyDodawanie.php" method="post">
			<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
			<input class="btn btn-primary" type="submit" name="DodawanieEgzaminu" value="Dodaj egzamin">
		</form>
		<?php } ?>	
		<div class="row g-4 py-5">
		
<table class="table table-striped table-hover">
  <thead>
    <tr>
		<th>Data i czas</th>
		<th>Wynik</th>
		<?php if(jestRola('uczen')) { ?>	
		<th>Edycja</th>
		<th>Usuwanie</th>
		<?php }  ?>	
    </tr>
  </thead>
  
  <tbody>
  
<?php

$polaczenie = polaczZBaza();

$sql = "SELECT ID, DataEgzaminu, CzasEgzaminu, Wynik FROM Egzaminy where UczenID=$uczenID";
$result = $polaczenie->query($sql);


while ($row = $result->fetch_assoc()) {
	
$id = $row["ID"];
$dataEgzaminu = $row["DataEgzaminu"];
$czasEgzaminu = $row["CzasEgzaminu"];
$wynik = $row["Wynik"];
?> 
	<tr>
		<td><?php print("$dataEgzaminu $czasEgzaminu"); ?></td>
		<td><?php print("$wynik"); ?></td>
		<?php if(jestRola('uczen')) { ?>	
		<td>
			<form action="egzaminyEdycja.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-success" type="submit" name="edycja" value="Edytuj">
			</form>
		</td>
		<td>
			<form action="egzaminy.php" method="post">
				<input type="hidden" name="id" value="<?php print("$id"); ?>">
				<input type="hidden" name="uczenID" value="<?php print("$uczenID"); ?>">
				<input class="btn btn-danger" type="submit" name="usuwanie" value="Usun">
			</form>
		</td>
		<?php }  ?>	
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