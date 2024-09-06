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

function menu() {
    ?>
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="index.php">Nauka Jazdy</a>
            <ul class="navbar-menu">
                <!-- Administrator -->
                <?php if(jestRola('administrator')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="samochody.php">Samochody</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="uzytkownicy.php">Użytkownicy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pakiety.php">Pakiety</a>
                </li>
                
                <!-- Instruktor -->
                <?php } else if(jestRola('instruktor')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="uzytkownicy.php">Uczniowie</a>
                </li>
                
                <!-- Uczeń -->
                <?php } else if(jestRola('uczen')) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="zakupionePakiety.php">Zakupione Pakiety</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="egzaminy.php">Egzaminy</a>
                </li>
                <?php } ?>
                
                <!-- Panel użytkownika i logowanie -->
                <?php if(zalogowany()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="panelUzytkownika.php">Panel użytkownika</a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="logowanie.php">Logowanie</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}


function displayFooter() {
    echo '
    <footer>
      <section>
        <div class="social-icons">
          <span>Dołącz do nas w mediach społecznościowych:</span>
          <a href="https://www.facebook.com/twoja-strona" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.twitter.com/twoja-strona" target="_blank"><i class="fab fa-twitter"></i></a>
          <a href="https://www.google.com" target="_blank"><i class="fab fa-google"></i></a>
          <a href="https://www.instagram.com/twoja-strona" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
      </section>

      <section>
        <div class="contact-info">
          <h6>Nauka Jazdy</h6>
          <p>Od 10 lat uczymy jeździć.</p>
        </div>
        <div class="contact-info">
          <h6>Kontakt</h6>
          <p><i class="fas fa-home"></i> Warszawa, ul. Zdawalnicza 12</p>
          <p><i class="fas fa-envelope"></i> info@naukajazdy.com</p>
          <p><i class="fas fa-phone"></i> +48 123 456 789</p>
          <p><i class="fas fa-print"></i> +48 987 654 321</p>
        </div>
        <div class="links">
          <h6>Przydatne linki</h6>
          <p><a href="#!" class="text-reset">Cennik</a></p>
          <p><a href="#!" class="text-reset">Harmonogram zajęć</a></p>
          <p><a href="#!" class="text-reset">Regulamin</a></p>
          <p><a href="#!" class="text-reset">Polityka prywatności</a></p>
        </div>
      </section>

      <div class="bottom">
        © 2024 Nauka Jazdy. Wszelkie prawa zastrzeżone.
      </div>
    </footer>';
}

