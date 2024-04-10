	<?php
	//Declaração de Variaveis Globais
	//String
	$ChaveBanco = "";
	$ChaveBanco2 = "";
	$ChaveBanco3 = "";
	//Numerico
	$Amigos = 0;
	$Off = 0;
	$On = 0;
	$nCont = 0;	
	$opc = 99;
	$nPed = 0;
	//Array
	$Usuario = [
		$_SESSION['Nome'],
		$_SESSION['Email'],
		$_SESSION['FotoPerfil']
	];
	$Pedidos = [];
	$Linha = [];
	$Linha2 = [];
	$Dados = [];
	//Constantes
	define('BD_AMIGO', 'BDs/bd_listamigos.csv');
	define('BD_USUARIO', 'BDs/bd_usuarios.csv');
	define('BD_ADD', 'BDs/bd_addamigo.csv');

	if(isset($_SESSION['Pagina']) and $_SESSION['Pagina'] === 'Amigos'){
		$opc = 1;
	}
	$_SESSION['Pagina'] = 'Home';//Seta na Página Home

	//==========================Funções============================
	//Retorna os dados do usuário exigido para construir o mesmo na lista de amigos
	function verificaUsuario($Email){
		$Ret = [false, ''];

		$ChaveBanco3 = fopen(BD_USUARIO, 'r');

		while (!feof($ChaveBanco3)) {
			$Linha2 = explode(';', fgets($ChaveBanco3));

			if (isset($Linha2[1]) === false) {
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

	function retornaUsuario($Email){
		$ChaveBanco3 = fopen(BD_USUARIO, 'r');

		while(!feof($ChaveBanco3)){
			$Ret = explode(';', fgets($ChaveBanco3));

			if (isset($Ret[1]) === false) {
				continue;
			}			

			if($Ret[1] === $Email){
				break;
			}
		}

		fclose($ChaveBanco3);
		
		return $Ret;
	}

	?>
	<?

	//================Valida os Amigos que o usuário tem adicionado ====================
	//Abre o arquivo para leitura
	$ChaveBanco = fopen(BD_AMIGO, 'r');
	$nLinha = 0;
	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if (isset($Linha[1]) === false) {
			continue;
		}
		$nLinha++;
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

	//================Valida Pedidos de Amizades caso existir para o usuário logado ====================
	$ChaveBanco = fopen(BD_ADD, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if (isset($Linha[1]) === false) {
			continue;
		}

		if($Linha[0] === $_SESSION['Nome']){
			$Pedidos[$nPed] = retornaUsuario($Linha[1]);
			$nPed++;
		}
	}

	//Fecha Arquivo
	fclose($ChaveBanco);
	?>
	<!-- Campo Responsaveis por avisos -->
	<div id="avisos"></div>	

	<!-- Lista de Amigos -->
	<div class="lista_amigos justify-content-center align-items-center text-dark">
		<div class="container bg-white">
			<div class="row">
				<div class="col-6 text-left">
					<p>
						Pedidos de Amizades<span class="ml-1 badge badge-pill badge-success"><?php echo($nPed); ?></span>
					</p>
				</div>
				<div class="col-6 text-right">
					<button onclick="lista_amigos()" type="button" class="btn btn-outline-danger mt-1">X</button>
				</div>
			</div>

			<pre class="pre_amigos my-2">
				<div id="pedidos_amizades" class="form-group p-1" action="script/adicionarAmigo.php" method="POST">
					<?php
						for($nCont = 0; $nCont <= $nPed -1; $nCont++){
					?>
					<fieldset class="form-group border border-dark rounded bg-secondary">
						<legend><?php echo($Pedidos[$nCont][3]); ?></legend>
						<div class="text-center">
							<img class="rounded-circle border border-dark" src="<?php echo($Pedidos[$nCont][5]); ?>" width="150" height="150">
							<p>
								Olá! 😊 Gostaria de me conectar com você. Seria um prazer compartilhar momentos juntos. Aguardo sua resposta! 🌟
							</p>
							<div class="d-flex justify-content-center">
								<input class="btn btn-info p-1 m-1" type="submit" name="Adicionar" value="adicionar(Adicionar <?php echo($Pedidos[$nCont][3]); ?>)">
								<input class="btn btn-info p-1 m-1" type="submit" name="Adicionar" value="adicionar(Recusar <?php echo($Pedidos[$nCont][3]); ?>)">
							</div>
						</div>
					</fieldset>	
					<?php
						}
					?>
				</div>
			</pre>
		</div>
	</div>

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
				<li class="nav-item" title="Amigos">
					<a onclick="rotaciona(1,1)" class="nav-link">
						<i class="fa-solid fa-user-group fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Adicionar Amigos">
					<a onclick="rotaciona(2,2)" class="nav-link">
						<i class="fa-solid fa-user-plus fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Configuração">
					<a onclick="rotaciona(3,3)" class="nav-link">
						<i class="fa-solid fa-gear fa-xl"></i>
					</a>
				</li>
				<li class="nav-item" title="Lista de Pedidos de Amizades">
					<a onclick="lista_amigos()" class="nav-link">
						<i class="fa-regular fa-address-book fa-xl">
							<span id="lista_amigos" class="badge badge-pill badge-success"><?php echo($nPed); ?></span>
						</i>
					</a>
				</li>				
				<li class="nav-item d-flex align-items-center">
					<a href="script/validaLogin.php" class="nav-link">
						<img src="<?php echo ($Usuario[2]); ?>" class="imagem border" width="30" height="30"
							title="Conectado: <?php echo ($Usuario[0]); ?>">
						<i class="fa-solid fa-right-from-bracket fa-xl" title="Sair">
							
						</i>
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
							Amigos
						</a>
					</li>
					<li class="nav-item p-2">
						<a onclick="rotaciona(2)" class="nav-link">
							<i class="fa-solid fa-comments fa-xl"></i>
							Add Amigos
						</a>
					</li>
					<li class="nav-item p-2">
						<a onclick="rotaciona(3)" class="nav-link">
							<i class="fa-solid fa-gear fa-xl"></i>
							Configuração
						</a>
					</li>
					<li class="nav-item p-2" title="Lista de Pedidos de Amizades">
						<a onclick="lista_amigos()" class="nav-link">
							<i class="fa-regular fa-address-book fa-xl">
								<span id="lista_amigos" class="badge badge-pill badge-success"><?php echo($nPed); ?></span>
							</i> Pedidos de Amizades
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

	<div id="Carregamento" class="d-none justify-content-center align-items-center m-auto flex-column">
		<div class="d-flex ">
			<h6 id="Loading">5%</h6>
			<div class="spinner-border spinner-border-sm mx-1"></div>
		</div>
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
								<time>09/04/2024</time>: Bug corrigido na função de adição e na lista de amigos.
								<br>														
								<time>09/04/2024</time>: Aprimoramos a funcionalidade de busca e adição de amigos, eliminando a necessidade de recarregar a página para atualizar os dados. Agora, essas operações são realizadas em tempo real, proporcionando uma experiência mais fluida. 	Em breve, outras áreas da página também serão atualizadas dinamicamente, aproveitando esse recurso.
								<br>																
								<time>04/04/2024</time>: Agora você pode Relatar Bugs, problemas de desempenho, erros ortográficos e entre outros, direto do contato 'Administrador de Sistemas' que ficará disponivel para você conversar.
								<br>																
								<time>04/04/2024</time>: Agora você pode Aceitar Pedidos de Amizades.
								<br>	
								<time>04/04/2024</time>: Agora você pode Recusar Pedidos de Amizades.
								<br>	
								<time>04/04/2024</time>: Adicionado à lista de pedidos de amizade.
								<br>	
								<time>01/04/2024</time>: Implementada a funcionalidade de busca e adição de amigos.
								<br>
								<time>28/03/2024</time>: Agora, ao passar o mouse sobre a frase 'Desenvolvido por Ighor Drummond©', ocorrerá uma animação de cores em forma de arco-íris, tanto no cubo quanto nas letras.
								<br>							
								<time>28/03/2024</time>: Se você estiver conectado em mais de um navegador e, em um deles, sua conta for desconectada, os demais também serão automaticamente desconectados por motivos de segurança.
								<br>
								<time>28/03/2024</time>: Corrigido bug de login em vários navegadores simultaneamente.
								<br>															
								<time>27/03/2024</time>: Adicionada navegação para dispositivos móveis (celulares, tablets, netbooks e notebooks).
								<br>								
								<time>27/03/2024</time>: Adicionada a opção de logout do site.
								<br>
								<time>27/03/2024</time>: A lista de amigos agora está funcional! Registra se o usuário está online ou offline.
								<br>								
								<time>26/03/2024</time>: Adicionada uma lista de amigos que informa se seus contatos estão online.
								<br>
								<time>26/03/2024</time>: Adicionada barra de navegação para orientar o usuário conforme sua navegação dentro da página.
								<br>
								<time>26/03/2024</time>: Adicionada uma tela de carregamento interativa para melhorar a experiência do usuário.
								<br>
								<time>25/03/2024</time>: Adicionada a página inicial (Home).
								<br>																				
							</pre>
							<a id="powered" onmouseover="animaCubo(1)" onmouseout="animaCubo(2)" href="https://ighordrummond.netlify.app">
								<h6>Desenvolvido por Ighor Drummond©</h6>
							</a>
						</div>
					</div>
					<div class="cubo-face back">
						<!-- Configuração -->

					</div>
					<div class="cubo-face right">right</div>
					<div class="cubo-face left">left</div>
					<div class="cubo-face top">
						<div id="AddAmigos" class="w-100 h-100 d-flex justify-content-center align-items-center flex-column">
							<h6 class="text-white">Adicione Amigos!</h6>
							<div class="border border-white w-75 h-75 p-1 d-flex flex-column">
								<pre id="lista_adds" class="w-100 h-100 bg-transparent">
									<ul class="list-group">
									</ul>
								</pre>
								<div class="input-group align-self-end">
									<input id="nomeAmigo" class="form-control" type="text" name="Amigo" placeholder="Pesquise Seus Amigos(as) Aqui..." required>
									<div class="input-group-append">
										<button id="buscarAmg" class="btn btn-primary">Pesquisar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
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
	<?php
		switch ($opc) {
			case 1:
	?>
				<script type="text/javascript" src="js/home_add.js"></script>
				<input class="d-none" readonly name="Amigos" value="Amigos">
	<?php
				break;
	?>	
	<?php
			default:
	?>			
				<script type="text/javascript" src="js/home.js"></script>
	<?php
				break;
		}
	?>
	<script type="text/javascript" src="js/posiCubo.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="js/homeControl.js"></script>