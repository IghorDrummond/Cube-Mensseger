<?php 
	require_once('script/validador_acesso_home.php');
	$_SESSION['Pagina'] = 'Home';
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once('script/estilos.php'); ?>
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
		//Numerico
		$Amigos  = 0;
		$Off = 0;
		$On = 0;
		//Array
		$Usuario = [
			$_SESSION['Nome'],
			$_SESSION['Email'],
			$_SESSION['FotoPerfil']
		];
		$Linha = [];
		//Constantes
		define('BD_AMIGO', 'BDs/bd_listamigos.txt');

	?>

	<!--Inicio da Navegação -->
	<header class="d-none w-100 bg-light my-1">
		<nav>
			<ul class="nav justify-content-center">
				<li class="nav-item actived" title="Página Inicial">
					<a onclick="rotaciona(0)" class="nav-link">
						<i class="fa-solid fa-house-user fa-xl"></i>
					</a>
				</li>		
				<li class="nav-item" title="Adicionar Amigos">
					<a onclick="rotaciona(1)" class="nav-link">
						<i class="fa-solid fa-user-group fa-xl"></i>
					</a>
				</li>	
				<li class="nav-item" title="Mensagens">
					<a onclick="rotaciona(2)" class="nav-link">
						<i class="fa-solid fa-comments fa-xl"></i>
					</a>
				</li>		
				<li class="nav-item"  title="Configuração">
					<a onclick="rotaciona(3)" class="nav-link">
						<i class="fa-solid fa-gear fa-xl"></i>
					</a>
				</li>	
				<li class="nav-item">
					<a href="acesso_sair.php" class="nav-link">
						<img src="<?php echo($Usuario[2]); ?>"  class="imagem border p-1" width="30" height="30" title="Conectado: <?php echo($Usuario[0]); ?>"></div>
						<i class="fa-solid fa-right-from-bracket fa-xl" title="Sair"></i>
					</a>
				</li>																	
			</ul>
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
							<img src="<?php echo($Usuario[2]); ?>" class="img-fluid p-1">
							<h5 class="mt-1">Olá, <?php echo($Usuario[0]); ?>!</h5>
							<pre><span class="text-warning">Atenção!</span> O Site se Encontra Ainda em uma Versão apenas de Desenvolvimento, As Tecnologias ainda estão sendo empregadas pouco-a-pouco no mesmo. Por enquanto, deslumbre do Design e funcionamento do <span class="text-info">Cube Mensseger!</span>
							</pre>
						</div>
					</div>
					<div class="cubo-face back">
						
					</div>
					<div class="cubo-face right">right</div>
					<div class="cubo-face left">left</div>
					<div class="cubo-face top">top</div>
					<div class="cubo-face bottom">
						<div id="Amigos" class="text-center">
						<?	
							//Abre o arquivo para leitura
							$ChaveBanco = fopen(BD_AMIGO, 'r');

							while (!feof($ChaveBanco)){
								$Linha = explode(';', fgets($ChaveBanco));

								if(isset($Linha[1]) === false){
									continue;
								}

								//Verifica se o usuário é amigo ou não dos outros demais
								if($Usuario[0] === $Linha[0]){



									//Define se está online o Usuário Amigo
									switch(verificaOnline($Linha[2])){
										case true:
											$On++;
											break;
										default:
											$Off++;
											break;
									}
								}
								$Amigos++;
								break;
							}

							//Fecha Arquivo
							fclose($ChaveBanco);

						?>
							<h6 class="text-white">Amigos<span class="badge badge-info"><? echo($Amigos) ?></span></h6>
							
							<div class="Amigos-lista d-flex flex-column justify-content-center align-items-center">
								<pre class="w-100 h-100"><!-- Inicio da Lista de Amigos -->
								<ul class="list-group"><!-- Inicio da Lista -->
									
								
						<?
								for($nCont = 0; $nCont <= 5; $nCont++){
						?>

										<li class="list-group-item bg-dark w-100">
											Lista
										</li>
						<?
								}
						?>	
									</ul><!-- Fim da Lista  -->
								</pre><!-- Fim da Lista de Amigos -->
								<div class="bg-white mt-auto w-100"><!-- Inicio da Metrica de Usuários -->	
									<h6 class="d-inline">Online<span class="badge badge-success"><? echo($On) ?></span></h6>
									<h6 class="d-inline">Offline<span class="badge badge-dark"><? echo($Off) ?></span></h6>
								</div><!-- Fim da Metrica de Usuários -->	
							</div>
						</div>
					</div>
				</div>
			</div>				
		</section><!-- Fim do Cubo -->
	</main>
	<!--Fim do Corpo -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts Obrigatórios -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/home.js"></script>
	<script type="text/javascript" src="js/posiCubo.js"></script>
	<?php ?>	
</body>

</html>