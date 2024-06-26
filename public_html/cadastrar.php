<?php 
	require_once('script/validador_acesso.php');
	$_SESSION['Pagina'] = 'Cadastrar';
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/cadastrar.css">

	<!-- Título da Página -->
	<title>Cube Mensseger - Cadastrar</title>
</head>

<body onresize="adaptar()">
		<?php
			$opc = 99;
			if(isset($_SESSION['Erro']) and $_SESSION['Erro'] != ''){
				if($_SESSION['Erro'] === 'Email'){
		?>
			<div id="Tela" class="w-100 bg-warning text-center p-2 fixed">
				<p class="mt-3">
					Usuário já cadastrado em Nossos Bancos, volte ao inicio para trocar senha caso tenha perdido a mesma.
				</p>
				<button class="btn btn-info p-2 m-2 w-50" onclick="Fechar()">Ok</button>
			</div>
		<?php
					$opc = 1;
				}else if($_SESSION['Erro'] === 'Senha'){
					$opc = 1;
		?>
			<div id="Tela" class="w-100 bg-warning text-center p-2 fixed">
				<p class="mt-3">
					As Senhas não se Correspondem, insira novamente as Senhas.
				</p>
				<button class="btn btn-info p-2 m-2 w-50" onclick="Fechar()">Ok</button>
			</div>		
		<?php		
				}
				$_SESSION['Erro'] = "";
			}else if(isset($_SESSION['Validacao']) and $_SESSION['Validacao'] === 'Cadastrado'){
				$opc = 2;
			}
		?>
	<header class="w-100 border border-dark bg-secondary font-weight-bold text-center">
		<nav>
			<h6>Digite a Nova Senha respeitando a Regra listadas abaixo:</h6>
			<ul>
				<li class="text-warning">Maxímo de 8 Caracteres</li>
				<li class="text-warning">Um ou Mais Letra Maíscula</li>
				<li class="text-warning">Um ou Mais Símbolo</li>
				<li class="text-warning">Um ou Mais Numero</li>
			</ul>
		</nav>
	</header>
	<main class="d-flex justify-content-center align-items-center ">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formularios">
						<form class=" text-center d-none formulario">
							<fieldset class="form-group">
								<legend for="Email">Email:</legend>
								<input class="form-control text-dark" placeholder="seuemail@email.com"disabled="disabled" readonly>				
							</fieldset>
							<fieldset class="form-group">
								<legend for="Senha">Senha:</legend>
								<input class="form-control text-dark" disabled="disabled" readonly>
							</fieldset>
							<input type="submit" class="btn btn-info" value="Entrar" disabled="disabled">					
						</form>
						<form class="d-none formulario text-center">
							<fieldset>
								<p>Está com Dificuldade para acessar? Tente Isso:</p>
								<input type="submit" class="btn btn-transparent" value="Cadastrar" disabled="disabled" readonly>
								<input type="submit" class="btn btn-transparent" value="Esqueci a Senha" disabled="disabled" readonly>
							</fieldset>		
						</form>
					</div>
				</div>
				<div class="cubo-face back d-flex justify-content-center align-items-center">
					<form class=" text-center formulario w-50 m-auto pt-1 fonte" action="script/cadastra.php" method="POST">
						<fieldset >
							<legend for="Email">Email:</legend>
							<label for="Email">Insira o Email: </label>
							<input class="form-control text-dark" name="Email" placeholder="seuemail@email.com" required>			
						</fieldset>
						<fieldset >
							<legend>Apelido:</legend>
							<label for="Nome">Insira o Nome: </label>
							<input class="form-control text-dark" name="Nome" type="text" maxlength="10" required placeholder="Nome">
							<label for="Sobrenome">Insira o Sobrenome: </label>
							<input class="form-control text-dark" name="Sobrenome" maxlength="10" type="text" required placeholder="Sobrenome">														
						</fieldset>
						<fieldset >
							<legend for="Senha">Senha:</legend>
							<label for="Senha">Insira a Senha: </label>
							<input class="form-control text-dark" onchange="DesligaCabecalho()" onkeyup="ValidaSenha()" name="Senha" type="password" required pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W+)(?=^.{8,50}$).*$">
							<label for="ConfirmeSenha">Confirme a Senha: </label>
							<input class="form-control text-dark" name="ConfirmeSenha" type="password" required pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W+)(?=^.{8,50}$).*$">							
						</fieldset>
						<input type="submit" class="btn btn-info" name="Acesso" value="Cadastrar" >
						<input type="button" class="btn btn-info" onclick="Voltar()"  value="Voltar" >
					</form>
				</div>
				<div class="cubo-face right"></div>
				<div class="cubo-face left"></div>
				<div class="cubo-face top">
				</div>
				<div class="cubo-face bottom"></div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts da Página -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	
	<?php
		switch($opc){
			case 1:
	?>
				<script type="text/javascript" src="js/telaCadastrar.js"></script>	
				<script type="text/javascript" src="js/erradoCuboCadastrar.js"></script>	
	<?php	
				break;
			case 2:
	?>					
				<script type="text/javascript" src="js/telaLogin.js"></script>
	<?php	
				break;
			default:
	?>	
				<script type="text/javascript" src="js/cadastrar.js"></script>	
	<?php		
				break;	
		}
	?>		
</body>
</html>