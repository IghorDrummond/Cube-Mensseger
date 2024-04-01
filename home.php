<?php
	require_once ('script/validador_acesso_home.php');
	$_SESSION['Pagina'] = 'Home';
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
	<!--Fim do Corpo -->
	<!-- Scripts Obrigatórios -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/home.js"></script>
	<script type="text/javascript" src="js/posiCubo.js"></script>
	<?php require_once ('script/scripts.php'); ?>
	<?php ?>
</body>

</html>