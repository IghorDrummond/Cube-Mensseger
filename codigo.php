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
		$opc = 99;

		if(isset($_SESSION['Erro']) and $_SESSION['Erro'] != ''){
			$opc = 1;

			if($_SESSION['Erro'] === 'Codigo'){
	?>
			<div id="Tela" class="fixed w-100 bg-warning text-center p-2 text-white font-weight-bold">
				<h6>Código Incorreto!</h6>
				<p class="mt-1">
					Por favor, insira um código válido para proceder com a troca de senha.
				</p>
				<button onclick="Fechar()" class="btn btn-info mt-1">Ok</button>
			</div>
	<?php	
			}else if($_SESSION['Erro'] === 'Data'){
	?>
			<div id="Tela" class="fixed w-100 bg-danger text-center p-2 text-white font-weight-bold">
				<h6>Código Inspirado!<h6>
				<p class="mt-1">
					Por favor, gere um novo código, pois o prazo de validade de um dia ou mais foi excedido.
				</p>
				<button onclick="Fechar()" class="btn btn-info mt-1">Ok</button>
			</div>			
	<?php
			}
			$_SESSION['Erro'] = "";
		}
	?>
	<main class="d-flex justify-content-center align-items-center">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formularios">
						<form class="text-center formulario">
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
						<form class="text-center formulario">
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
					<div class="text-center codigo">
						<form class="form-group text-center m-auto" action="script/valida_codigo.php" method="POST">
							<fieldset>
								<legend>Insira o Código</legend>
								<input class="d-none" type="email" name="Email" value="<? echo($_GET['Email']); ?>" readonly>
								<input class="form-control text-center" type="text" name="Codigo" placeholder="..." maxlength="8" required>	
							</fieldset>
							<fieldset class="bg-secondary">
								<label>
									<span class="text-warning">Atenção:</span>
									O código é válido por um dia útil para utilização; caso contrário, não será aceito e será necessário gerar um novo.
								</label>
							</fieldset>
							<input type="submit" name="Acesso" value="Enviar" class="btn btn-info mt-2">
						</form>
						<button class="btn btn-info mt-2" onclick="VoltarXY()">Voltar</button>
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
</body>
</html>