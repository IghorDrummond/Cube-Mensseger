<?php
	//Liga a Sessão Atual
	session_start();
	//Declaração de Variaveis
	//String
	$opc = $_GET['opc'];
	//Array
	$Ret = [];
	//Constantes
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_ADD', '../BDs/bd_addamigo.csv');

	//==========================Escopo========================================
	//Define a Data do Sistema
	date_default_timezone_set('America/Sao_Paulo');

	//Valida qual operação a ser tratada
	switch ($opc) {
		case '1':
			$Ret = atualizaAmigos();
			break;
		case '2':
			$Ret = atualizaLista();
			break;	
		case '3':
			$Ret = atualizaNav();
			break;				
	}
	//Retorna o Elemento HTML correto para o requisitante.
	retornaItem($Ret, $opc);

	//==========================Funções============================
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: atualizaAmigos()
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por atualizar quem está ou não está online no servidor além de atualizar amigos novos ou deletados
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function atualizaAmigos(){
		//Declaração de Variaveis
		//Numerico
		$Amigos = 0;
		$nLinha = 0;
		$On = 0;
		$Off = 0;
		$nCont = 0;
		//Array
		$Dados = [];
		$Aux = [];	
		$Usuario = [
			$_SESSION['Nome'],
			$_SESSION['Email'],
			$_SESSION['FotoPerfil']
		];	

		//================Valida os Amigos que o usuário tem adicionado ====================
		//Abre o arquivo para leitura
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
		//Dados para retornar
		$Ret[0] = $On;
		$Ret[1] = $Off;
		$Ret[2] = $Amigos;
		$Ret[3] = $Dados;
		return $Ret;
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: atualizaLista()
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por atualizar a Lista de Pedidos de Amizades em Tempo Real
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function atualizaLista(){
		//Declaração de Variaveis
		//Numerico
		$nPed = 0;
		//Array
		$Pedidos = [];

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false) {
				continue;
			}

			if($Linha[0] === $_SESSION['Email']){
				$Pedidos[$nPed] = retornaUsuario($Linha[1]);
				$nPed++;
			}
		}

		//Fecha Arquivo
		fclose($ChaveBanco);
		//Retorna os Dados
		$Ret[0] = $Pedidos;
		$Ret[1] = $nPed;

		return $Ret;
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: atualizaNav()
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por atualizar a barra de navegação em tempo real
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function atualizaNav(){
		//Declaração de Variaveis
		//Numerico
		$nPed = 0;

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false){
				continue;
			}

			if($Linha[0] === $_SESSION['Email']){
				$nPed++;
			}
		}

		//Fecha Arquivo
		fclose($ChaveBanco);
		//Retorna os Dados
		$Ret[0] = $nPed;
		return $Ret;			
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: verificaUsuario(Email ao ser tratado)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retorna os dados do usuário exigido para construir o mesmo na lista de amigos	
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function verificaUsuario($Email){
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
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: retornaUsuario(Email ao ser tratado)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retorna os dados do usuário.
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
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
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: calculaData($Recebe a Data para ser Calculada)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retornara o Ultimo Acesso calculado do Usuário Offline
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function calculaData($Data){
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

		// Verifica se a diferença é em Anos, Meses, Dias, Horas, Minutos ou Segundos.
		if($diferenca->y > 0){
			$Ret = $diferenca->y . ' Ano  Atrás' ;		
		} elseif ($diferenca->days > 0) {
			$Ret = $diferenca->days . " Dias Atrás";
		} elseif ($diferenca->h > 0) {
			$Ret = $diferenca->h . " Horas Atrás";
		} elseif ($diferenca->i > 0) {
			$Ret = $diferenca->i . " Minutos Atrás";
		}
		else {
			$Ret = "Agora Pouco";
		}

		return $Ret;
	}	
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: Mensagem(Email a ser validado as Mensagens)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por validar quantidade de mensagens que foram enviadas
	--------------------------------------------------------------------------------------------------------------	
	Data: 19/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function Mensagens($Email, $Amigo){
		$ChaveBanco2 = fopen(BD_AMIGO, 'r');
		$nQtdUser = [-1, -1];
		$Ret = 0;

		while(!feof($ChaveBanco2)){
			$Linha = explode(';', fgets($ChaveBanco2));

			if(isset($Linha[1]) === false){
				continue;
			}
			str_replace(PHP_EOL, '', $Linha[5]);

			if($Linha[0] === $_SESSION['Email'] and $Linha[1] === $Amigo){
				$nQtdUser[0] = intval($Linha[5]);
			}else if($Amigo  === $Linha[0] and $Linha[1] === $Email){
				$nQtdUser[1] = intval($Linha[5]);
 			}

			if($nQtdUser[0] != -1 and $nQtdUser[1] != -1){
				break;
			}
		}

		fclose($ChaveBanco2);

		if($nQtdUser[0] < $nQtdUser[1]){
			$Ret = $nQtdUser[1] - $nQtdUser[0];
		}

		return strval($Ret) . ' Mensagens';
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: retornaItem(Dados para Preencher os Elementos HTML, Operação Escolhida)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por retornar o Elemento HTML de determinada Opção
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function retornaItem($Ret, $opc){
		if($opc === '1'){
			$On = $Ret[0];
			$Off = $Ret[1];
			$Amigos = $Ret[2];
			$Dados = $Ret[3];
?>
							<h6 class="text-white">Amigos<span class="badge badge-info"><?php echo ($Amigos) ?></span></h6>
							<div class="Amigos-lista d-flex flex-column justify-content-center align-items-center">
								<pre onscroll="posicTag(4)" class="w-100 h-100"><!-- Inicio da Lista de Amigos -->
									<ul class="list-group"><!-- Inicio da Lista -->
						<?php
							foreach ($Dados as $Valor) {
						?>
											<li class="list-group-item bg-info text-center w-100 d-flex justify-content-between align-items-center" id="<?php echo ($Valor[2]) ?>">
												<img src="<?php echo ($Valor[4]) ?>" class="border border-dark" align="left">
												<div>
													<h6 class="d-inline"><?php echo ($Valor[0]) ?></h6>
											<?php
												//Valida se o usuário está online
												if ($Valor[3]) {
											?>
														<span class="badge badge-success ">Online</span>
														<span><?php echo($Valor[6]); ?></span>
														<time>⌛Agora</time>
														
											<?php
												} else {
											?>
														<span class="badge badge-dark ">Offline</span>
														<span><?php echo($Valor[6]); ?></span>
														<time>⏳<?php echo($Valor[5]); ?></time>
											<?php
												}
											?>	
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

<?php
	 	}
		elseif ($opc === '2') {
			$Pedidos = $Ret[0];
			$nPed = $Ret[1];
?>
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

			<pre onscroll="posicTag(0)" class="pre_amigos my-2">
				<div class="form-group p-1">
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
								<input class="btn btn-info p-1 m-1" type="button" onclick="adicionar('Adicionar*<?php echo($Pedidos[$nCont][1]); ?>')" value="Adicionar <?php echo($Pedidos[$nCont][3]); ?>">
								<input class="btn btn-warning p-1 m-1 text-white" type="button" onclick="adicionar('Recusar*<?php echo($Pedidos[$nCont][1]); ?>')" value="Recusar <?php echo($Pedidos[$nCont][3]); ?>">
							</div>
						</div>
					</fieldset>	
					<?php
						}
					?>					
				</div>
			</pre>		
<?php
		}
		elseif ($opc === '3') {
			$nPed = $Ret[0];			
?>
						<i class="fa-regular fa-address-book fa-xl">
							<span class="badge badge-pill badge-success pedidos_amizades"><?php echo($nPed); ?></span>
						</i>
<?php
		}
		elseif ($opc === '4') {		
?>		

<?php
		}
	}
?>