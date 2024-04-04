<?php
	require_once ('script/validador_acesso_home.php');
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once ('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/home.css">	

	<!-- Título da Página -->
	<title>Cube Mensseger</title>
</head>

<body onresize="adaptar()">
	<?php require_once('script/homebuild.php'); ?>
	<?php require_once ('script/scripts.php'); ?>
</body>

</html>