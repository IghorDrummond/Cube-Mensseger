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
	$nLinha = 0;
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

	if (isset($_SESSION['Pagina']) and $_SESSION['Pagina'] === 'Amigos') {
		$opc = 1;
	}
	$_SESSION['Pagina'] = 'Home';//Seta na Página Home

	//==========================Funções============================
	//Retorna os dados do usuário exigido para construir o mesmo na lista de amigos
	function verificaUsuario($Email)
	{
		$Ret = [false, '', ''];
		//Online ou Offline, Foto do Usuário, Ultimo Acesso do Usuário

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
				$Ret[1] = $Linha2[5];
				$Ret[2] = str_replace(PHP_EOL, '', $Linha2[6]);
				break;
			}
		}

		fclose($ChaveBanco3);
		return $Ret;
	}
	function calculaData($Data)
	{
		//Declaração de Variaveis
		//Numericos
		$dataInicial = null;
		$dataFinal = null;
		$diferenca = null;

		// Converte as datas em objetos DateTime
		$dataInicial = new DateTime($Data);
		$dataFinal = new DateTime(Date('Y-m-d H:i:s'));
		//calcula a diferença de segundos entre as duas datas
		$diferenca = $dataInicial->diff($dataFinal);

		// Verifica se a diferença é em dias, horas ou minutos
		//Declaração de Variaveis
		//Numericos
		$dataInicial = null;
		$dataFinal = null;
		$diferenca = null;

		// Converte as datas em objetos DateTime
		$dataInicial = new DateTime($Data);
		$dataFinal = new DateTime(Date('Y-m-d H:i:s'));
		//calcula a diferença de segundos entre as duas datas
		$diferenca = $dataInicial->diff($dataFinal);

		// Verifica se a diferença é em dias, horas ou minutos
		if ($diferenca->y > 0) {
			$Ret = $diferenca->y . ' Ano  Atrás';
		} elseif ($diferenca->days > 0) {
			$Ret = $diferenca->days . " Dias Atrás";
		} elseif ($diferenca->h > 0) {
			$Ret = $diferenca->h . " Horas Atrás";
		} elseif ($diferenca->i > 0) {
			$Ret = $diferenca->i . " Minutos Atrás";
		} else {
			$Ret = "Agora Pouco";
		}

		return $Ret;
	}
	function Mensagens($User, $User2)
	{
		$nCont = 0;
		$Tam = 0;
		$Linhas = file(BD_AMIGO);//lÊ TODAS AS LINHAS DO ARQUIVO
		$Linha = [];

		$Tam = count($Linhas) - 1;

		for ($nCont = $Tam; $nCont >= 0; $nCont--) {
			$Linha = explode(';', $Linhas[$nCont]);

			if ($Linha[0] === $User2 and $Linha[1] === $User) {
				$Ret = retornaVistos($Linha[3]);
				break;
			}
		}

		return strval($Ret) . ' <i class="fa-solid fa-message"></i>';
	}
	function retornaVistos($id)
	{
		$nCont = 0;
		$Tam = 0;
		$Ret = 0;
		$Linhas = file('BDs/BD_CONVERSA/' . $id . '.txt');//lÊ TODAS AS LINHAS DO ARQUIVO
		$Linha = [];

		$Tam = count($Linhas) - 1;

		for ($nCont = $Tam; $nCont >= 0; $nCont--) {
			$Linha = explode(';', $Linhas[$nCont]);

			if (isset($Linha[1]) === false) {
				continue;
			}

			$Linha[5] = str_replace(PHP_EOL, '', $Linha[5]);

			if ($Linha[5] === 'N' and $Linha[1] != $_SESSION['Email']) {
				$Ret++;
			} else if ($Linha[5] === 'S' and $Linha[1] != $_SESSION['Email']) {
				break;
			}
		}

		return $Ret;
	}

	//================Valida os Amigos que o usuário tem adicionado ====================
	$ChaveBanco = fopen(BD_AMIGO, 'r');
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
			$Dados[$nCont][2] = $Linha[3];//Recebe o Nome da Conversa do Amigo
			$Dados[$nCont][3] = false; //Valida se o usuário está Online ou Offiline
			$Aux = verificaUsuario($Linha[1]);//Retorna Foto e Data do ultimo Login
			$Dados[$nCont][4] = $Aux[1]; //Recebe a Imagem do Usuário
			$Dados[$nCont][5] = calculaData($Aux[2]);//Recebe o Ultimo Acesso do Usuário
			$Dados[$nCont][6] = Mensagens($Linha[0], $Linha[1]);//Recebe o Ultimo Acesso do Usuário

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

	//================Valida a quantidade de Pedidos Enviados ====================
	$ChaveBanco = fopen(BD_ADD, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if (isset($Linha[1]) === false) {
			continue;
		}

		if ($Linha[0] === $_SESSION['Email']) {
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
	<div id="pedidos_amizades" class="container bg-white"></div>
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
					<i class="fa-solid fa-user-group fa-xl">
						<span class="badge badge-pill badge-success notificacao_msg">0</span>
					</i>
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
				<a id="pedidos_amigos" onclick="lista_amigos()" class="nav-link">
					<i class="fa-regular fa-address-book fa-xl">
						<span class="badge badge-pill badge-success pedidos_amizades"><?php echo ($nPed); ?></span>
					</i>
				</a>
			</li>
			<li class="nav-item d-flex align-items-center">
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
						<i class="fa-solid fa-user-group fa-xl">
							<span class="badge badge-pill badge-success notificacao_msg">0</span>
						</i>
						Amigos
					</a>
				</li>
				<li class="nav-item p-2">
					<a onclick="rotaciona(2)" class="nav-link">
						<i class="fa-solid fa-user-plus fa-xl"></i>
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
					<a id="pedidos_amigos" onclick="lista_amigos()" class="nav-link ped">
						<i class="fa-regular fa-address-book fa-xl">
							<span class="badge badge-pill badge-success pedidos_amizades"><?php echo ($nPed); ?></span>
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
	<div class="d-flex">
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
					<div id="Novidades" class="d-none">
						<img src="<?php echo ($Usuario[2]); ?>" class="img-fluid p-1">
						<h5 class="mt-1">Olá,
							<?php echo ($Usuario[0]); ?>!
						</h5>
						<pre onscroll="posicTag(1)"><span class="text-warning">Notas de Atualização!</span>
									<?php require_once ('script/atts.php'); ?>		
								</pre>
						<a id="powered" onmouseover="animaCubo(1)" onmouseout="animaCubo(2)"
							href="https://ighordrummond.netlify.app">
							<h6>Desenvolvido por Ighor Drummond©</h6>
						</a>
					</div>
				</div>
				<div class="cubo-face back p-2">
					<!-- Configuração -->
					<div id="Configuracao" class="bg-white h-100 w-100 d-none">

					</div>
				</div>
				<div class="cubo-face right p-2 text-dark">

					<pre id="Conversar">
							<!-- Receberá  Atts Aqui das Mensagens -->
						</pre>
					<div class="input-group">
						<input class="form-control Mensagem" type="text" placeholder="Digite Algo...">
						<div class="input-group-append">
							<button class="Enviar btn btn-primary" onclick="tarefa('Enviar')">
								<i class="fa-solid fa-paper-plane fa-xl" style="color: white;"></i>
							</button>
						</div>
					</div>

				</div>
				<div class="cubo-face left">left</div>
				<div class="cubo-face top">
					<div id="AddAmigos"
						class="w-100 h-100 d-none justify-content-center align-items-center flex-column">
						<h6 class="text-white">Adicione Amigos!</h6>
						<div class="border border-white w-75 h-75 p-1 d-flex flex-column">
							<pre onscroll="posicTag(2)" id="lista_adds" class="w-100 h-100 bg-transparent">
										<ul class="list-group">
										</ul>
									</pre>
							<div class="input-group align-self-end">
								<input id="nomeAmigo" class="form-control" type="text" name="Amigo"
									placeholder="Pesquise Seus Amigos(as) Aqui..." required>
								<div class="input-group-append">
									<button id="buscarAmg" class="btn btn-primary">Pesquisar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="cubo-face bottom">
					<div id="Amigos" class="text-center d-none">
							<h6 class="text-white">Amigos<span class="badge badge-info"><?php echo ($Amigos) ?></span></h6>
							<div class="Amigos-lista d-flex flex-column justify-content-center align-items-center">
								<pre onscroll="posicTag(4)" class="w-100 h-100"><!-- Inicio da Lista de Amigos -->
									<ul class="list-group"><!-- Inicio da Lista -->
						<?php
							foreach ($Dados as $Valor) {
						?>
											<li class="list-group-item bg-info text-center w-100 d-flex justify-content-between align-items-center amigo_lista_item" id="<?php echo ($Valor[2]) ?>">
												<img src="<?php echo ($Valor[4]) ?>" class="border border-dark" align="left">
												<div>
													<h6 class="d-inline"><?php echo ($Valor[0]) ?></h6>
											<?php
												//Valida se o usuário está online
												if ($Valor[3]) {
											?>
														<span class="badge badge-success ">Online</span>
														<time>⌛Agora</time>
														
											<?php
												} else {
											?>
														<span class="badge badge-dark ">Offline</span>
														<time>⏳<?php echo($Valor[5]); ?></time>
											<?php
												}
											?>	
														<span class="Mensagens">
															<?php echo($Valor[6]); ?>
														</span>
												</div>
												<ul class="opcao_lista">
													<li class="bg-primary p-1 border rounded" onclick="tarefa('Conversar <?php echo($Valor[2]); ?>')">Conversar</li>	
											<?php
												//Valida se o usuário está online
												if ($Valor[1] != 'admin@cubemensseger.com') {
											?>
													<li class="border p-1 bg-secondary rounded" onclick="tarefa('Silenciar<?php echo($Valor[1]); ?>')">Silenciar</li>
													<li class="border p-1 bg-warning rounded" onclick="tarefa('Bloquear <?php echo($Valor[1]); ?>')">Bloquear</li>
													<li class="border p-1 bg-danger rounded" onclick="tarefa('Deletar <?php echo($Valor[1]); ?>')">Deletar</li>
											<?php
												}
											?>	
												</ul>
											</li>												
						<?php
							}
						?>	
									</ul><!-- Fim da Lista  -->
								</pre><!-- Fim da Lista de Amigos -->
								<div class="bg-white mt-auto w-100"><!-- Inicio da Metrica de Usuários -->
									<h6 class="d-inline">Online<span class="badge badge-success">
											<?php echo ($On) ?>
										</span></h6>
									<h6 class="d-inline">Offline<span class="badge badge-dark">
											<?php echo ($Off) ?>
										</span></h6>
								</div><!-- Fim da Metrica de Usuários -->
							</div>
						</div>
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