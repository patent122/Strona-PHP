<?php
	session_start();
	require("funkcje.php");
?>

<!doctype html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Regulamin szkoły nauki jazdy">
    <meta name="author" content="Patryk Panek">
    <title>Regulamin - Nauka Jazdy</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="style.css"> 

  </head>

<body>
	<main class="main-content">
		<?php menu(); ?>
		<div class="container_2">
			<h1 class="page-title">Regulamin Szkoły Nauki Jazdy</h1>

			<section class="regulations-section">
				<h2 class="section-title">1. Postanowienia ogólne</h2>
				<p class="section-text">Szkoła Nauki Jazdy prowadzi kursy teoretyczne i praktyczne w zakresie prawa jazdy kategorii B. Każdy uczestnik kursu jest zobowiązany do przestrzegania zasad zawartych w niniejszym regulaminie.</p>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">2. Zasady uczestnictwa w kursach</h2>
				<ul class="section-list">
					<li class="list-item">Wiek minimalny uczestnika: 18 lat lub 17 lat z możliwością rozpoczęcia kursu za zgodą rodziców.</li>
					<li class="list-item">Każdy uczestnik zobowiązany jest do dostarczenia zaświadczenia lekarskiego o braku przeciwwskazań do prowadzenia pojazdów.</li>
					<li class="list-item">Uczestnik kursu zobowiązany jest do systematycznego uczęszczania na zajęcia teoretyczne oraz praktyczne.</li>
				</ul>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">3. Zasady płatności</h2>
				<ul class="section-list">
					<li class="list-item">Koszt kursu ustalany jest według obowiązującego cennika.</li>
					<li class="list-item">Płatność za kurs może być rozłożona na raty.</li>
					<li class="list-item">Brak terminowej wpłaty może skutkować zawieszeniem uczestnictwa w kursie.</li>
				</ul>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">4. Zasady odwoływania zajęć</h2>
				<p class="section-text">Uczestnik kursu ma prawo do odwołania zajęć praktycznych z co najmniej 24-godzinnym wyprzedzeniem. W przeciwnym razie godzina jazdy zostanie zaliczona jako odbyta.</p>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">5. Zasady bezpieczeństwa</h2>
				<ul class="section-list">
					<li class="list-item">Każdy uczestnik kursu zobowiązany jest do przestrzegania przepisów ruchu drogowego podczas zajęć praktycznych.</li>
					<li class="list-item">Kursanci muszą stawiać się na zajęcia w stanie pełnej trzeźwości.</li>
					<li class="list-item">Instruktorzy mają prawo do przerwania zajęć, jeśli uznają, że kursant stanowi zagrożenie dla bezpieczeństwa ruchu drogowego.</li>
				</ul>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">6. Warunki ukończenia kursu</h2>
				<p class="section-text">Kurs zostaje uznany za ukończony, gdy uczestnik zrealizuje minimalną wymaganą liczbę godzin teoretycznych i praktycznych oraz zaliczy wewnętrzny egzamin teoretyczny i praktyczny.</p>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">7. Reklamacje i zwroty</h2>
				<p class="section-text">Wszelkie reklamacje dotyczące kursów należy zgłaszać pisemnie na adres szkoły. Zwrot kosztów kursu jest możliwy tylko w uzasadnionych przypadkach, za zgodą kierownictwa szkoły.</p>
			</section>

			<section class="regulations-section">
				<h2 class="section-title">8. Postanowienia końcowe</h2>
				<p class="section-text">Szkoła Nauki Jazdy zastrzega sobie prawo do zmiany regulaminu. Aktualny regulamin dostępny jest na stronie internetowej szkoły.</p>
			</section>
		</div>
	</main>

	<?php displayFooter(); ?>
</body>
</html>
