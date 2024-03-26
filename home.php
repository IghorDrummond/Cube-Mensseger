<?php 
	require_once('script/validador_acesso_home.php');
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

<body>
	<?php ?>

	<!--Inicio da Navegação -->
	<header class=" w-100 bg-light my-1 p-1">
		<nav>
			<ul class="nav justify-content-center">
				<li class="nav-item active">
					<a href="" class="nav-link">
						<i class="fa-solid fa-house-user fa-xl" title="Página Inicial"></i>
					</a>
				</li>		
				<li class="nav-item">
					<a href="" class="nav-link">
						<i class="fa-solid fa-user-group fa-xl" title="Adicionar Amigos"></i>
					</a>
				</li>	
				<li class="nav-item">
					<a href="" class="nav-link">
						<i class="fa-solid fa-comments fa-xl" title="Mensagens"></i>
					</a>
				</li>		
				<li class="nav-item">
					<a href="" class="nav-link">
						<i class="fa-solid fa-gear fa-xl" title="Configuração"></i>
					</a>
				</li>													
			</ul>
		</nav>
	</header>
	<!--Fim da Navegação -->

	<!--Inicio do Corpo -->
	<main class="d-flex justify-content-center align-items-center flex-column">	
		<!-- Cubo -->
		<section><!-- Inicio do Cubo -->
			<div class="cena">
				<div class="cubo">
					<div class="cubo-face front d-flex justify-content-center align-items-center">

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
	<script src="https://kit.fontawesome.com/c488e9ed48.js" crossorigin="anonymous"></script>
	<?php ?>	
</body>

</html>