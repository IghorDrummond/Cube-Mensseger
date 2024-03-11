<?php 
	require_once('script/validador_acesso.php');
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/login.css">

	<!-- Título da Página -->
	<title>Cube Mensseger - Login</title>
</head>

<body onscroll="rotacionaCubo()">
	<main class="d-flex justify-content-center align-items-center ">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formularios">
						<img src="img/balao.png" class="img-fluid balao">
						<form class=" text-center d-none formulario">
							<fieldset class="form-group">
								<legend for="Email">Email:</legend>
								<input class="form-control text-dark" name="Email" placeholder="seuemail@email.com"disabled="disabled" readonly>				
							</fieldset>
							<fieldset class="form-group">
								<legend for="Senha">Senha:</legend>
								<input class="form-control text-dark"  name="Senha"disabled="disabled" readonly>
							</fieldset>
							<input type="submit" class="btn btn-info" name="Acesso" value="Entrar" disabled="disabled">					
						</form>
						<form class="d-none formulario text-center">
							<fieldset>
								<p>Está com Dificuldade para acessar? Tente Isso:</p>
								<input type="submit" class="btn btn-transparent" name="Acesso" value="Cadastrar" disabled="disabled" readonly>
								<input type="submit" class="btn btn-transparent" name="Acesso" value="Esqueci a Senha" disabled="disabled" readonly>
							</fieldset>		
						</form>
					</div>
				</div>
				<div class="cubo-face back">
				</div>
				<div class="cubo-face right"></div>
				<div class="cubo-face left"></div>
				<div class="cubo-face top"></div>
				<div class="cubo-face bottom"></div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/cadastrar.js"></script>				
</body>

</html>