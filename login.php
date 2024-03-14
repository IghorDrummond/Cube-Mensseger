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

<body>
	<?php 
		$opc = 99;
		if(isset($_SESSION['Erro']) and $_SESSION['Erro'] != ''){
			if($_SESSION['Erro'] === 'Senha'){
				$opc = 0;
	?>
		<div id="Tela" class="bg-danger text-center font-weight-bold w-100 border border-dark ">
			<h6 class="mt-3">Usuário ou Senha Incorretas!</h6>
			<p class="mt-3">
				Caso Esqueceu a senha, seleciona "Esqueci a Senha".
			</p>
			<button class="my-2 p-2 btn btn-info m-2 w-50" onclick="Fechar()">Ok</button>
		</div>

	<?php
			}
			else if($_SESSION['Erro'] === 'Email'){
				$opc = 0;
	?>
		<div id="Tela" class="bg-warning text-center font-weight-bold w-100 border border-dark ">
			<h6>Usuário não Existe!</h6>
			<p>
				Usuário não Existe em Nossos Registro, caso queira cadastrar, selecione a opção "Cadastrar".
			</p>
			<button class="my-2 p-2 btn btn-info w-25" onclick="Fechar()">Ok</button>
		</div>
	<?php
			}
			//Limpa dados de Erros após ser utilizados
			$_SESSION['Erro'] = '';
		}
		//Valida se veio de páginas direcionada para login
		if(isset($_SESSION['Pagina'])){
			//Valida se veio de páginas direcionada para login
			if($_SESSION['Pagina'] === 'Cadastrar'){
				$opc = 1;
			}else if($_SESSION['Pagina'] === 'Senha'){
				$opc = 1;
			}
			//Reseta a página
			$_SESSION['Pagina'] = "";
		}
		if(isset($_SESSION['Validacao']) and $_SESSION['Validacao'] === 'Cadastrado'){
			$opc = 1;
	?>	
		<div id="Tela" class="bg-success text-center font-weight-bold w-100 border border-dark fixed ">
			<h6>Usuário Cadastrado!</h6>
			<p>
				Faça seu Primeiro Acesso logando no cubo abaixo.
			</p>
			<button class="my-2 p-2 btn btn-info w-25" onclick="Fechar()">Ok</button>
		</div>
	<?php
			//Reseta a validação
			$_SESSION['Validacao'] = "";
		}
	?>
	<main class="d-flex justify-content-center align-items-center flex-column ">	
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
								<a class="btn btn-info" href="cadastrar.php">Cadastrar</a>
								<a class="btn btn-info" href="esqueciSenha.php">Esqueci a Senha</a>
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

	<?php
		switch ($opc) {
			case 0:
	?>		
		<script type="text/javascript" src="js/ajustaTamanho.js"></script>			
		<script type="text/javascript" src="js/erradoCubo.js"></script>	
	<?php
				break;
			case 1:
	?>			
		<script type="text/javascript" src="js/ajustaTamanho.js"></script>	
	<?php
				break;
			default:
	?>		
		<script type="text/javascript" src="js/login.js"></script>	
	<?php			
				break;
		}
	?>	

	<script type="text/javascript" src="js/janelas.js"></script>	
</body>

</html>