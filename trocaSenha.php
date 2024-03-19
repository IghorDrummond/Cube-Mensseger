<?php 
	require_once('script/valida_acesso_senha.php');
	$_SESSION['Pagina'] = 'Senha';
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
	<!-- Estilo da Página -->
	<link rel="stylesheet" type="text/css" href="css/renovaSenha.css">

	<!-- Título da Página -->
	<title>Cube Mensseger - Recupera Senha</title>
</head>

<body onresize="adaptar()">
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
	<main class="d-flex justify-content-center align-items-center">
		<!-- Cubo -->
		<div class="cena d-none">
			<div class="cubo">
				<div class="cubo-face front d-flex justify-content-center align-items-center">
					<div class="formularios">
						<form class="text-center">
							<fieldset class="form-group">
								<legend for="Email">Email:</legend>
								<input class="form-control text-dark" type="email" name="Email" placeholder="seuemail@email.com" readonly disabled="disabled">				
							</fieldset>
							<fieldset class="form-group">
								<legend for="Senha">Senha:</legend>
								<input class="form-control text-dark" type="password" readonly disabled="disabled">
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
					<div class="text-center codigo">
						<form class="form-group text-center m-auto" action="script/valida_codigo.php" method="POST">
							<fieldset>
								<legend>Insira o Código</legend>
								<input class="form-control text-center" type="text" name="Codigo" placeholder="..." maxlength="8" readonly disabled="disabled">	
							</fieldset>
							<fieldset class="bg-secondary">
								<label>
									<span class="text-warning">Atenção:</span>
									O código é válido por um dia útil para utilização; caso contrário, não será aceito e será necessário gerar um novo.
								</label>
							</fieldset>
							<input type="submit" name="Acesso" value="Enviar" class="btn btn-info mt-2" readonly disabled="disabled">
						</form>
						<button class="btn btn-info mt-2" disabled="disabled">Voltar</button>
					</div>		

					<div class="w-100 codigo d-none">
						<form class="form-group p-2" action="script/renovaSenha.php" method="POST">
							<input type="email" name="Email" readonly class="d-none" value="email">
							<fieldset class="form-group">
								<legend for="Senha">Digite a nova Senha:</legend>
								<input onkeyup="ValidaSenha()" type="password" name="Senha" class="form-control" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W+)(?=^.{8,50}$).*$" maxlength="12" required>
							</fieldset>
							<fieldset class="form-group">
								<legend for="ConfirmeSenha">Confirme a Senha:</legend>
								<input type="password" name="ConfirmeSenha" class="form-control" pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W+)(?=^.{8,50}$).*$" maxlength="12" required>
							</fieldset>		
							<input type="submit" name="Acesso" value="Enviar" class="btn btn-info d-block m-auto">
						</form>
					</div>
				</div>
				<div class="cubo-face left"></div>
				<div class="cubo-face top"></div>
				<div class="cubo-face bottom"></div>
			</div>
		</div>
	</main>
	<!-- Scripts Obrigatórios -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts da Página -->
	<script type="text/javascript" src="js/renovaSenha.js"></script>
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>	
	<script type="text/javascript" src="js/janelas.js"></script>
</body>
</html>