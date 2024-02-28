<?php
function polaczZBaza()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "nauka_jazdy2";
	$mysqli = new mysqli($servername, $username, $password, $database);
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
	}
	return $mysqli;
}


function poleWymagane($nazwaPola)
{
	if(!isset($_POST[$nazwaPola]) || $_POST[$nazwaPola]=="")	{
		print("<p>Pole '$nazwaPola' jest wymagane</p>");
		return false;
	}
	return true;
}

function powtorzenieHasla($poleHaslo, $poleHaslo2)
{
	if($_POST[$poleHaslo] != $_POST[$poleHaslo2])
	{
		print("<p>Hasła sie nie zgadzają</p>");
		return false;
	}
	return true;
}

function zalogowany()
{
	return isset($_SESSION['user']) && $_SESSION['user'] != '';
}

function jestRola($nazwaRoli)
{
	return zalogowany() && $_SESSION['rola']==$nazwaRoli;
}

function wybranaRola($rolaZBazy, $rolaWOpcji)
{
	if($rolaZBazy == $rolaWOpcji)
	{
		echo "SELECTED";
	}
}

function menu()
{
	?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Fourth navbar example">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Nauka jazdy</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	
	

	
      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
		<?php if(jestRola('administrator')) { ?> 
		<li class="nav-item">
            <a class="nav-link" aria-current="page" href="samochody.php">Samochody</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" aria-current="page" href="uzytkownicy.php">Uzytkownicy</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" aria-current="page" href="pakiety.php">Pakiety</a>
          </li>
			<?php } else if(jestRola('instruktor')) { ?> 
			<li class="nav-item">
				<a class="nav-link" aria-current="page" href="uzytkownicy.php">Uczniowie</a>
			</li>
			<?php } else if(jestRola('uczen')) { ?> 
		 
           <li class="nav-item">
            <a class="nav-link" aria-current="page" href="zakupionePakiety.php">Zakupione pakiety</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" aria-current="page" href="egzaminy.php">Egzaminy</a>
          </li>
		  <?php }  
				if(zalogowany()) { ?> 
			<li class="nav-item">
            <a class="nav-link" href="panelUzytkownika.php">Panel użytkownika</a>
          </li>
			<?php }  ?>
		  <li class="nav-item">
            <a class="nav-link" href="logowanie.php">Logowanie</a>
          </li>
		  
		  
		  
        </ul>
      </div>
	  

	  
    </div>
  </nav>
<?php
}

function displayFooter() {
    echo '
    <script src="bootstrap.bundle.min.js"></script>

    <footer class="text-center text-lg-start bg-light text-muted">
      <section class="d-flex justify-content-center p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
          <span>Dołącz do nas w mediach społecznościowych:</span>
        </div>

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
      </section>

      <section class="">
        <div class="container text-center text-md-start mt-5">
          <div class="row mt-3">
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
              <h6 class="text-uppercase fw-bold mb-4">
                <i class="fas fa-gem me-3"></i>Nauka Jazdy
              </h6>
              <p>Od 10 lat uczymy jeździć.</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
              <h6 class="text-uppercase fw-bold mb-4">Kontakt</h6>
              <p><i class="fas fa-home me-3"></i> Warszawa, ul. Zdawalnicza 12</p>
              <p><i class="fas fa-envelope me-3"></i> info@naukajazdy.com</p>
              <p><i class="fas fa-phone me-3"></i> + 48 123 456 789</p>
              <p><i class="fas fa-print me-3"></i> + 48 987 654 321</p>
            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
              <h6 class="text-uppercase fw-bold mb-4">Przydatne linki</h6>
              <p><a href="#!" class="text-reset">Cennik</a></p>
              <p><a href="#!" class="text-reset">Harmonogram zajęć</a></p>
              <p><a href="#!" class="text-reset">Regulamin</a></p>
              <p><a href="#!" class="text-reset">Polityka prywatności</a></p>
            </div>
          </div>
        </div>
      </section>

      <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2024 Nauka Jazdy. Wszelkie prawa zastrzeżone.
      </div>
    </footer>

    <script src="bootstrap.bundle.min.js"></script>
    ';
}
?>


