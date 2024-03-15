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

<body onresize="adaptar()">
	<?php

	?>
	<main class="d-flex justify-content-center align-items-center">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formulario">
						<form class="text-center">
							<fieldset class="form-group">
								<legend for="Email">Email:</legend>
								<input class="form-control text-dark" type="email" name="Email" placeholder="seuemail@email.com" readonly disabled="disabled">				
							</fieldset>
							<fieldset class="form-group">
								<legend for="Senha">Senha:</legend>
								<input class="form-control text-dark" type="password" name="Senha" readonly disabled="disabled">
							</fieldset>
							<input type="submit" class="btn btn-info" name="Acesso" value="Entrar" readonly disabled="disabled">
						</form>
						<form class="text-center">
							<fieldset>
								<p>Está com Dificuldade para acessar? Tente Isso:</p>
								<a class="btn btn-info" readonly disabled="disabled">Cadastrar</a>
								<a class="btn btn-info" readonly disabled="disabled">Esqueci a Senha</a>
							</fieldset>		
						</form>
					</div>
				</div>
				<div class="cubo-face back"></div>
				<div class="cubo-face right d-flex justify-content-center align-items-center">
					<!-- Alterar Aqui --->
					<div class="bg-warning">
						<button onclick="VoltarXY()">Voltar</button>
					</div>
				</div>
				<div class="cubo-face left"></div>
				<div class="cubo-face top"></div>
				<div class="cubo-face bottom d-flex justify-content-center align-items-center">
					<form class="codigo text-center m-auto pt-1">
						<fieldset class="container-fluid">
							<legend for="Email">Email:</legend>
							<label for="Info">Insira seu Email ou Nome e Sobrenome cadastrado no Site:</label>
							<input class="form-control text-dark w-100" name="Info" placeholder="<? echo($_GET['Email']) ?>" readonly disabled="disabled">				
						</fieldset>
						<input type="submit" class="btn btn-info" name="Acesso" value="Enviar" readonly disabled="disabled">
						<input type="button" class="btn btn-info mt-1"  value="Voltar" readonly disabled="disabled">
					</form>
				</div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts da Página -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/codigo.js"></script>

	<?php

	?>
</body>
</html>