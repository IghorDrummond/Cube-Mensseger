<?php 
	require_once('script/validador_acesso.php');
	$_SESSION['Pagina'] = 'Senha';
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/login.css">

	<!-- Título da Página -->
	<title>Cube Mensseger - Recupera Senha</title>
</head>

<body onscroll="rotacionaCubo()">
		<?php
			if(isset($_SESSION['Erro']) and $_SESSION['Erro'] != ''){
				if($_SESSION['Erro'] === 'Email'){
		?>
			<div id="Tela" class="w-100 bg-warning text-center p-2 fixed">
				<p>
					Usuário não Existe em Nossos Bancos, insira um email valido ou cadastre uma conta.
				</p>
				<button class="btn btn-info p-2 my-1" onclick="Voltar()">Voltar</button>
			</div>
		<?php
				}
			}
		?>	
	
	<main class="d-flex justify-content-center align-items-center ">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formularios">
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
				<div class="cubo-face back"></div>
				<div class="cubo-face right"></div>
				<div class="cubo-face left"></div>
				<div class="cubo-face top"></div>
				<div class="cubo-face bottom d-flex justify-content-center align-items-center">
					<form class=" text-center formulario w-50 m-auto pt-1 fonte" action="script/recuperaSenha.php" method="POST">
						<fieldset class="container-fluid">
							<legend for="Email">Email:</legend>
							<label for="Info">Insira seu Email ou Nome e Sobrenome cadastrado no Site:</label>
							<input class="form-control text-dark w-100" name="Info" placeholder="Email ou Nome e Sobrenome" required>				
						</fieldset>
						<input type="submit" class="btn btn-info" name="Acesso" value="Enviar" >
						<input type="button" class="btn btn-info" onclick="VoltarDir()"  value="Voltar" >
					</form>
				</div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts da Página -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/janelas.js"></script>
	<script type="text/javascript" src="js/esqueciSenha.js"></script>	
	
</body>
</html>