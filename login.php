<?php require_once('script/validador_acesso.php') ?>
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
	<?php 
		if(isset($_SESSION['Erro'])){
			if($_SESSION['Erro'] === 'Senha'){
	?>
		<div id="Tela" class="bg-danger text-center font-weight-bold w-100 border border-dark ">
			<h6>Usuário ou Senha Incorretas!</h6>
			<p>
				Caso Esqueceu a senha, seleciona "Esqueci a Senha".
			</p>
			<button class="mt-2 p-2 bg-info" onclick="Fechar()">Ok</button>
		</div>

	<?php
			}
			else if($_SESSION['Erro'] === 'Email'){
	?>
		<div id="Tela" class="bg-warning text-center font-weight-bold w-100 border border-dark ">
			<h6>Usuário não Existe!</h6>
			<p>
				Usuário não Existe em Nossos Registro, caso queira cadastrar, selecione a opção "Cadastrar".
			</p>
			<button class="mt-2 p-2 bg-info" onclick="Fechar()">Ok</button>
		</div>
	<?php
			}
			//Limpa o Erro após ser Utilizado
			//$_SESSION['Erro'] = '';
		}
	?>
	<main class="d-flex justify-content-center align-items-center ">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div>
						<img src="img/balao.png" class="img-fluid balao">
						<form class=" text-center d-none formulario" action="script/validaLogin.php" method="POST">
							<fieldset class="form-group">
								<legend for="Email">Email:</legend>
								<input class="form-control text-dark" type="email" name="Email" placeholder="seuemail@email.com" required>				
							</fieldset>
							<fieldset class="form-group">
								<legend for="Senha">Senha:</legend>
								<input class="form-control text-dark" type="password" name="Senha" required>
							</fieldset>
							<input type="submit" class="btn btn-info" name="Acesso" value="Entrar">					
						</form>
						<form class="d-none formulario text-center">
							<fieldset>
								<p>Está com Dificuldade para acessar? Tente Isso:</p>
								<input type="submit" class="btn btn-transparent border border-light" name="Acesso" value="Cadastrar">
								<input type="submit" class="btn btn-transparent border border-light" name="Acesso" value="Esqueci a Senha">
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

	<script type="text/javascript" src="js/login.js"></script>
</body>

</html>