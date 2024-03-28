<!DOCTYPE html>
<html>
	<head>
	    <?php  require_once('script/estilos.php'); ?>
		<!-- Estilo da Página -->
		<link rel="stylesheet" type="text/css" href="css/index.css">
		
		<!-- Título da Página -->
		<title>Cube Mensseger</title>
	</head>
	<body>
		<main>
			<section class="text-center">
				<h1 id="Titulo">Cube Mensseger</h1>
				<div class="cena">
					<div class="cubo">
					    <div class="cubo-face front">
					    	<div class=" d-flex justify-content-center align-items-center texto">
					    		<p class="text-center text-dark "></p>	
					    	</div>			    
					    </div>
					    <div class="cubo-face back d-flex justify-content-center align-items-center">
					    	<button onclick="Entrar()" class="btn btn-info border border-dark">Entrar</button>
					    </div>
					    <div class="cubo-face right"></div>
					    <div class="cubo-face left"></div>
					    <div class="cubo-face top"></div>
					    <div class="cubo-face bottom"></div>
					</div>					
				</div>
			</section>
			<section class="text-center mt-5 pt-3">
				<h3>
					Acesse o Melhor Mensageiro da Atualidade!
				</h3>

				<h6 class="pt-2">
					Para Acessar sua conta, basta clicar no Cubo.
				</h6>
			</section>
		</main>
		<!-- Scripts Obrigatórios -->
		<?php  require_once('script/scripts.php'); ?>
		<script type="text/javascript" src="js/index.js"></script>
	</body>
</html>