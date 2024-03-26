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
		//Array
		$Usuario = [];
		$Linha = [];
	?>

	<!--Inicio da Navegação -->
	<header class="d-none w-100 bg-light my-1 p-1">
		<nav>
			<ul class="nav justify-content-center">
				<li class="nav-item active" title="Página Inicial">
					<a href="" class="nav-link">
						<i class="fa-solid fa-house-user fa-xl"></i>
					</a>
				</li>		
				<li class="nav-item" title="Adicionar Amigos">
					<a href="" class="nav-link">
						<i class="fa-solid fa-user-group fa-xl"></i>
					</a>
				</li>	
				<li class="nav-item" title="Mensagens">
					<a href="" class="nav-link">
						<i class="fa-solid fa-comments fa-xl"></i>
					</a>
				</li>		
				<li class="nav-item"  title="Configuração">
					<a href="" class="nav-link">
						<i class="fa-solid fa-gear fa-xl"></i>
					</a>
				</li>	
				<li class="nav-item">
					<a href="acesso_sair.php" class="nav-link">
						<img src="BDs/BD_FOTOS/novo-usuario.png" class="imagem border p-1" width="30px" title="Conectado: Ighor"></div>
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
					<div class="cubo-face front d-flex justify-content-center align-items-center">
						front
					</div>
					<div class="cubo-face back">
					</div>
					<div class="cubo-face right"></div>
					<div class="cubo-face left"></div>
					<div class="cubo-face top"></div>
					<div class="cubo-face bottom"></div>
				</div>
			</div>				
		</section><!-- Fim do Cubo -->
	</main>
	<!--Fim do Corpo -->
	<?php require_once('script/scripts.php'); ?>

	<!-- Scripts Obrigatórios -->
	<script type="text/javascript" src="js/ajustaTamanho.js"></script>
	<script type="text/javascript" src="js/home.js"></script>
	<?php ?>	
</body>

</html>