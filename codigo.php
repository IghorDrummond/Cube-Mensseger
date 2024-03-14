<?php 
	require_once('script/validador_acesso.php');
	$_SESSION['Pagina'] = 'Senha';
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/codigo.css">

	<!-- Título da Página -->
	<title>Cube Mensseger - Recupera Senha</title>
</head>

<body>
	<?php ?>

	
	<main class="d-flex justify-content-center align-items-center ">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front">front</div>
				<div class="cubo-face back ">back</div>
				<div class="cubo-face right ">right</div>
				<div class="cubo-face left">left</div>
				<div class="cubo-face top ">top</div>
				<div class="cubo-face bottom d-flex justify-content-center align-items-center ">
					bottom
					<form class=" text-center formulario w-50 m-auto pt-1 fonte" action="script/recuperaSenha.php" method="POST">
						<fieldset class="container-fluid">
							<legend for="Email">Email:</legend>
							<label for="Info">Insira seu Email ou Nome e Sobrenome cadastrado no Site:</label>
							<input class="form-control text-dark w-100" name="Info" placeholder="Email ou Nome e Sobrenome" readonly disabled="disabled">				
						</fieldset>
						<input type="submit" class="btn btn-info" name="Acesso" value="Enviar" readonly disabled="disabled">
						<input type="button" class="btn btn-info"  value="Voltar" readonly disabled="disabled">
					</form>
				</div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts da Página -->
	<?php
		switch($opc){

			case 1:
	?>
				<script type="text/javascript" src="js/codigo_fixado.js"></script>	
				<script type="text/javascript" src="js/erradoCuboCodigo.js"></script>	
	<?php
				break;
			default:
	?>
				<script type="text/javascript" src="js/codigo.js"></script>	
	<?php
				break;
		}	
	?>	
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/janelas.js"></script>	
</body>
</html>