<?php



?>
<html lang="pl">
	<head>
		<title>Portal społeczenościowy</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="styl5.css">
	</head>
	<body>
		<div class="baner banerlewy">
			<h2>Nasze osiedle</h2>
		</div>
		<div class="baner banerprawy">
			<?php
			$db = mysqli_connect("localhost","root","","portal");
			$query = mysqli_query($db, "SELECT count(id) FROM uzytkownicy");
			echo "<h5>Liczba użytkowników portalu: ".(mysqli_fetch_row($query)[0])."</h5>";
			mysqli_close($db);
			?>
		</div>
	
		<div class="lewy">
			<h3>Logowanie</h3>
			<form method="POST">
				login<br>
				<input name="login"><br>
				hasło<br>
				<input type="password" name="haslo"><br>
				<input type="submit" value="Zaloguj">
			</form>
		</div>
		<div class="prawy">
			<h3>Wizytówka</h3>
			<div class="wizytowka">
				<?php
				if(isset($_POST['login']) and isset($_POST['haslo'])) {
					$db = mysqli_connect("localhost","root","","portal");
					$query = mysqli_query($db, "SELECT haslo FROM uzytkownicy WHERE login = '{$_POST['login']}'");
					$haslo = mysqli_fetch_row($query)[0] ?? "";
					if($haslo) {
						if($haslo == sha1($_POST['haslo'])) {
							$query = mysqli_query($db, "SELECT login, rok_urodz, przyjaciol, hobby, zdjecie FROM uzytkownicy INNER JOIN dane ON uzytkownicy.id = dane.id WHERE login = '{$_POST['login']}'");
							$dane = mysqli_fetch_row($query);
							echo "<img src='obrazy/{$dane[4]}' alt='osoba'>";
							$wiek = 2022 - $dane[1];
							echo "<h4>{$dane[0]} ($wiek)</h4>";
							echo "<p>hobby: {$dane[3]}</p>";
							echo "<h1><img src='obrazy/icon-on.png'>{$dane[2]}</h1>";
							echo "<a href='dane.html'><button>Więcej informacji</button></a>";
						} else {
							echo "hasło nieprawidłowe";
						}
					} else {
						echo "login nie istnieje";
					}
				}
				?>
			</div>
		</div>

		<div class="stopa">
			Stronę wykonał: 1234567890
		</div>
	</body>
</html>