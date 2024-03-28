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
	<?php
	//Declaração de Variaveis Globais
	//String
	$ChaveBanco = "";
	$ChaveBanco2 = "";
	//Numerico
	$Amigos = 0;
	$Off = 0;
	$On = 0;
	$nCont = 0;
	//Array
	$Usuario = [
		$_SESSION['Nome'],
		$_SESSION['Email'],
		$_SESSION['FotoPerfil']
	];
	$Linha = [];
	$Linha2 = [];
	$Dados = [];
	//Constantes
	define('BD_AMIGO', 'BDs/bd_listamigos.txt');
	define('BD_USUARIO', 'BDs/bd_usuarios.txt');

	function verificaUsuario($Email)
	{
		$Ret = [false, ''];

		$ChaveBanco3 = fopen(BD_USUARIO, 'r');

		while (!feof($ChaveBanco3)) {
			$Linha2 = explode(';', fgets($ChaveBanco3));

			if (isset($Linha2) === false) {
				continue;
			}


			if ($Linha2[1] === $Email) {
				if ($Linha2[4] === 'On') {
					$Ret[0] = true;
				}
				$Ret[1] = str_replace(PHP_EOL, '', $Linha2[5]);
				break;
			}
		}

		fclose($ChaveBanco3);

		return $Ret;
	}

	?>
	<?
	//Abre o arquivo para leitura
	$ChaveBanco = fopen(BD_AMIGO, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if (isset($Linha[1]) === false) {
			continue;
		}

		//Verifica se o usuário é amigo ou não dos outros demais
		if ($Usuario[1] === $Linha[0]) {

			$Amigos++;
			//Guarda Informação do Amigo Cadastrado
			$Dados[$nCont][0] = $Linha[2];//Recebe o Nome do Amigo
			$Dados[$nCont][1] = $Linha[1];//Recebe o Email do Amigo
			$Dados[$nCont][2] = $Linha[4];//Recebe o Nome da Conversa do Amigo
			$Dados[$nCont][3] = false;
			$Aux = verificaUsuario($Linha[1]);
			$Dados[$nCont][4] = $Aux[1]; //Recebe a Imagem do Usuário
	
			//Define se está online o Usuário Amigo
			switch ($Aux[0]) {
				case true:
					$On++;
					$Dados[$nCont][3] = true;
					break;
				default:
					$Off++;
					break;
			}
			$nCont++;
		}
	}

	//Fecha Arquivo
	fclose($ChaveBanco);

	?>

	<!--Inicio da Navegação -->
	<header class="d-none w-100 bg-light my-1">
		<!-- Inicio do Menu Desktop -->
		<nav class="d-none d-lg-block">
			<ul class="nav justify-content-center d-none d-lg-flex">
				<li class="nav-item actived" title="Página Inicial">
					<a onclick="rotaciona(0,0)" class="nav-link">
						<i class="fa-solid fa-house-user fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Adicionar Amigos">
					<a onclick="rotaciona(1,1)" class="nav-link">
						<i class="fa-solid fa-user-group fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Mensagens">
					<a onclick="rotaciona(2,2)" class="nav-link">
						<i class="fa-solid fa-comments fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Configuração">
					<a onclick="rotaciona(3,3)" class="nav-link">
						<i class="fa-solid fa-gear fa-xl"></i>
					</a>
				</li>
				<li class="nav-item">
					<a href="script/validaLogin.php" class="nav-link">
						<img src="<?php echo ($Usuario[2]); ?>" class="imagem border" width="30" height="30"
							title="Conectado: <?php echo ($Usuario[0]); ?>">
						<i class="fa-solid fa-right-from-bracket fa-xl" title="Sair"></i>
						<?php echo ($Usuario[0]); ?>
					</a>
				</li>
			</ul>
		</nav>

		<!-- Inicio do Menu Mobile -->
		<nav class="navbar-nav navbar-expand-lg">
			<button class="navbar-toggler w-100" data-toggle="collapse" data-target="#nav-mobile">
				<span class="navbar-toggler-icon">
					<i class="fa-solid fa-bars fa-xl"></i>
				</span>
			</button>

			<div class="collapse" id="nav-mobile">
				<ul class="navbar-nav text-dark">
					<li class="nav-item p-2">
						<a onclick="rotaciona(0)" class="nav-link">
							<i class="fa-solid fa-house-user fa-xl"></i>
							Página Inicial
						</a>
					</li>
					<li class="nav-item p-2">
						<a onclick="rotaciona(1)" class="nav-link">
							<i class="fa-solid fa-user-group fa-xl"></i>
							Adicionar Amigos
						</a>
					</li>
					<li class="nav-item p-2">
						<a onclick="rotaciona(2)" class="nav-link">
							<i class="fa-solid fa-comments fa-xl"></i>
							Mensagens
						</a>
					</li>
					<li class="nav-item p-2">
						<a onclick="rotaciona(3)" class="nav-link">
							<i class="fa-solid fa-gear fa-xl"></i>
							Configuração
						</a>
					</li>
					<li class="nav-item p-2 text-center">
						<a href="script/validaLogin.php" class="nav-link">
							<img src="<?php echo ($Usuario[2]); ?>" class="imagem border" width="30" height="30">
							<i class="fa-solid fa-right-from-bracket fa-xl d-inline d-lg-none" title="Sair"></i>
							<br>
							<?php echo ($Usuario[0]); ?>
						</a>
					</li>
				</ul>
			</div>
		</nav>		
	</header>
	<!--Fim da Navegação -->

	<div id="Carregamento" class="d-flex justify-content-center align-items-center m-auto flex-column">
		<h6 id="Loading">5%</h6>
		<div class="progress w-50">
			<div class="progress-bar bg-info progress-bar-striped progress-bar-animated" style="width: 5%;"></div>
		</div>
	</div>

	<!--Inicio do Corpo -->
	<main class="d-flex justify-content-center align-items-center flex-column">
		<!-- Cubo -->
		<section><!-- Inicio do Cubo -->
			<div class="cena">
				<div class="cubo">
					<div class="cubo-face front d-flex align-items-center justify-content-center">
						<div id="Novidades">
							<img src="<?php echo ($Usuario[2]); ?>" class="img-fluid p-1">
							<h5 class="mt-1">Olá,
								<?php echo ($Usuario[0]); ?>!
							</h5>
							<pre><span class="text-warning">Notas de Atualização!</span> 
								<time>27/03/2024</time>: Adicionado Navegação para Dispositivos Mobile(Celurares, Tablets, Netbook e Outbooks).
								<br>								
								<time>27/03/2024</time>: Adicionado a opção Logoff do Site.
								<br>
								<time>27/03/2024</time>: A lista de Amigos agora é funcional! Registra se o usuário está online ou não.
								<br>								
								<time>26/03/2024</time>: Adicionado uma Lista de Amigos ao qual informa se seus amigos estão Onlines.
								<br>
								<time>26/03/2024</time>: Adicionado a barra de navegação para orientação do Usuário de acordo com a navegação dentro da página
								<br>
								<time>26/03/2024</time>: Adicionado uma tela de carregamento interativa com o usuário.
								<br>
								<time>25/03/2024</time>: Adicionado a Página Home.
								<br>																						
							</pre>
						</div>
					</div>
					<div class="cubo-face back">back</div>
					<div class="cubo-face right">right</div>
					<div class="cubo-face left">left</div>
					<div class="cubo-face top">top</div>
					<div class="cubo-face bottom">
						<div id="Amigos" class="text-center">
							<h6 class="text-white">Amigos<span class="badge badge-info">
									<? echo ($Amigos) ?>
								</span></h6>
							<div class="Amigos-lista d-flex flex-column justify-content-center align-items-center">
								<pre class="w-100 h-100"><!-- Inicio da Lista de Amigos -->
									<ul class="list-group"><!-- Inicio da Lista -->
						<?
							foreach ($Dados as $Valor) {
						?>
											<li class="list-group-item bg-info text-center w-100" id="<? echo ($Valor[2]) ?>">
												<img src="<? echo ($Valor[4]) ?>" class="border border-dark" align="left">
												<h6 class="d-inline"><? echo ($Valor[0]) ?></h6>
											<?
												//Valida se o usuário está online
												if ($Valor[3]) {
											?>
														<span class="badge badge-success ">Online</span>
											<?
												} else {
											?>
														<span class="badge badge-dark ">Offline</span>
											<?
												}
											?>
											</li>
						<?
							}
						?>	
									</ul><!-- Fim da Lista  -->
								</pre><!-- Fim da Lista de Amigos -->
								<div class="bg-white mt-auto w-100"><!-- Inicio da Metrica de Usuários -->
									<h6 class="d-inline">Online<span class="badge badge-success">
											<? echo ($On) ?>
										</span></h6>
									<h6 class="d-inline">Offline<span class="badge badge-dark">
											<? echo ($Off) ?>
										</span></h6>
								</div><!-- Fim da Metrica de Usuários -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section><!-- Fim do Cubo -->
	</main>
	<!--Fim do Corpo -->
	<!-- Scripts Obrigatórios -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/home.js"></script>
	<script type="text/javascript" src="js/posiCubo.js"></script>
	<?php require_once ('script/scripts.php'); ?>
	<?php ?>
</body>

</html>