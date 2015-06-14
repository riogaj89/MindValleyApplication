<?php
session_start();
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">		
		<title>URL Shortener</title>
		<link rel="stylesheet" href="css/global.css">
	</head>
	<body background="bg2.jpg">
		<div class="container"> 
			<h1 class="title">Shorten a URL</h1>

			<?php

			if(isset($_SESSION['feedback'])){
			?>	
			<script type="text/javascript">
				document.body.style.backgroundImage="url('bg3.jpg')";
			</script>
			<?php
				echo "<p>{$_SESSION['feedback']}</p>";
				unset($_SESSION['feedback']);																				
			} else{
				echo "<p>Brighten the day...</p>";
			}			
			?>

			<form action="shorten.php" method="post">
				<input type="url" name="url" id ="url" value="http://" autocomplete="off">							
				<input type="submit" name="submit" value="Shorten">
			</form>	
		</div>
	</body>
</html>