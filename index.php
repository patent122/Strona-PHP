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

    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="style.css"> 

  </head>

<body>
	<main>
		<?php menu(); ?>

		<div class="container">
			<div class="row">
				<img src="grafika/naukaJazdy.png" alt="nauka jazdy" class="image">
			</div>
		</div>
	</main>

	<?php displayFooter(); ?>
</body>
</html>
