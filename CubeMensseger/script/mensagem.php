<?php
	//Sessão Atual
	session_start();
	//Declaração de Variaveis
	//String
	$id = $_GET['id'];
	$Mensagem = isset($_GET['Mensagem']) ? $_GET['Mensagem'] : '';
	$Qtd = isset($_GET['msgqtd']) ? $_GET['msgqtd'] : '';
	$ChaveBanco = '';
	//Numerico
	$nLinha = 0;
	//Array
	$Dados = [];
	//Constantes
	define('BD_USUARIO', '../../CubeMensseger/BDs/bd_usuarios.csv');
	define('BD_AMIGO', '../../CubeMensseger/BDs/bd_listamigos.csv');	
	define('BD_MSG', '../../CubeMensseger/BDs/BD_CONVERSA/'. $id);
	define('BD_BLOQUEADO', '../../CubeMensseger/BDs/bd_bloqueado.csv');	

	//Define o horario 
	date_default_timezone_set('America/Sao_Paulo');

	if(strlen($Mensagem) > 0){
		$ChaveBanco = fopen(BD_MSG, 'a+');
		$Mensagem = trataMensagem($Mensagem);
		$Msg = $_SESSION['Nome'] . ';' . $_SESSION['Email'] . ';' . $Mensagem . ';' .  $_SESSION['FotoPerfil'] . ';' . Date('Y-m-d H:i:s') . ';' . 'N' . PHP_EOL;
		fwrite($ChaveBanco, $Msg);
		fclose($ChaveBanco);
	}
	//Adiciona Visto para as conversas caso não houver
	atualizaVisto();

	$Dados = retornaUsuario($id);
	//Caso o valor retornado seja falso, apresenta o chat Morto
	$Dados === false ? chatMorto($id) : "";
	//Constrói o Cabeçalho do Chat
?>
							<div class="d-flex justify-content-between align-items-center bg-white rounded p-2 border sticky-top">
								<img class="rounded-circle border img-fluid logo_conversa" src="<?php echo($Dados[4]); ?>">
								<h6><?php echo($Dados[0]); ?>
									<?php
										if($Dados[5] and validaBloqueado($Dados[1], $_SESSION['Email']) === false){
									?>
										<span class="badge badge-pill badge-success" style="height: 15px;  width: 15px; border-radius: 90%;">&nbsp</span>
									<?php
										}else if($Dados[5] === false ){
									?>
										<span class="badge badge-pill badge-secondary rounded-circle" style="height: 15px;  width: 15px; border-radius: 90%;">&nbsp</span>
									<?php
										}
									?>
								</h6>
								<h6 onclick="tarefa('Sair <?php echo($id); ?>')" class="text-info">Voltar</h6>
							</div>

							<div class="d-flex justify-content-between flex-column ">
<?php
	//Responsavel por trazer as mensagens para o usuário
	$ChaveBanco = fopen(BD_MSG, 'r');

	while (!feof($ChaveBanco)) {
		//nome do usuário, email do usuário, mensagem, imagem do usuário, data da mensagem
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}
		$nLinha++;
		$Linha[4] = str_replace(PHP_EOL, '', $Linha[4]);

		//Define a classe padrão para você mas caso não foi você que enviou, colocará como amigo
		$Classe = 'you ml-auto bg-success ';	
		if($Linha[0] != $_SESSION['Nome']){
			$Classe = 'amigo mr-auto bg-info ';
		}

		//Formata Texto para caixa baixa.
		$Linha[0] = ucfirst(strtolower($Linha[0]));

		if(strlen($Linha[2]) <= 560){
			$Classe .= 'p-1';
		}else if(strlen($Linha[2]) > 560 and  strlen($Linha[2]) <= 1000){
			$Classe .= 'p-3';
		}else if(strlen($Linha[2]) > 1000 and  strlen($Linha[2]) <= 1440){
			$Classe .= 'p-4';
		}else if(strlen($Linha[2]) > 1440){
			$Classe .= 'p-5';
		}

		$Classe .= " w-50 text-center m-2";
?>
								<blockquote class="<?php echo($Classe); ?>">
									<div class="d-flex alig-items-center justify-content-center">
										<cite class="info text-warning"><?php echo($Linha[0]); ?> -&nbsp</cite>
										<time class="info"><?php print(calculaData($Linha[4])) ?></time>	
									</div>
								  	<p><?php print(destrataMensagem($Linha[2])); ?></p>	
								  	<?php 
										if($Linha[1] === $_SESSION['Email']){
											$Linha[5] = str_replace(PHP_EOL, '', $Linha[5]);
											echo(retornaVisualizacao($Linha[5]));								  			
								  		}
									?>	
								</blockquote>
<?php
	}
?>
							</div><!-- Fim das Mensagens-->		
							<button class="w-25 btn btn-primary fixed-bottom m-auto descer" title="Mensagens Não Lidas" onclick="desceChat()">Descer <span class="descer badge badge-dark"></span> <span class="sr-only">Mensagens não lidas</span>
							</button>					
<?php
	fclose($ChaveBanco);//Fecha arquivo

	if($nLinha === 0){
?>		
	<div class="rounded border text-center p-1 text-info">
		<p>
			Você e <?php echo($Dados[0]) ?> ainda não conversaram. Envie um 'Oi' para iniciar uma conversa.
		</p>
	</div>
<?php		
	}
	//===============================Funções=================================
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: retornaUsuario(Id da Conversa)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retorna os dados do usuário.
	--------------------------------------------------------------------------------------------------------------	
	Data: 11/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/
	function retornaUsuario($Id){
		$ChaveBanco = fopen(BD_AMIGO, 'r');
		$Dados = [];
		$lTem = false;
		
		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false) {
				continue;
			}

			//Verifica se o usuário é amigo ou não dos outros demais
			if ($Id === $Linha[3] and $_SESSION['Email'] === $Linha[0]) {
				//Guarda Informação do Amigo Cadastrado
				$Dados[0] = ucfirst(strtolower($Linha[2]));//Recebe o Nome do Amigo
				$Dados[1] = $Linha[1];//Recebe o Email do Amigo
				$Dados[2] = $Linha[3];//Recebe o Nome da Conversa do Amigo
				$Dados[3] = false; //Valida se o usuário está Online ou Offiline
				$Aux = verificaUsuario($Linha[1]);//Retorna Foto e Data do ultimo Login
				$Dados[4] = $Aux[1]; //Recebe a Imagem do Usuário
				$Dados[5] = $Aux[0]; //Recebe se ele está Online ou Não
				$lTem = true;
				break;
			}
		}

		fclose($ChaveBanco);
		
		return !$lTem ? false : $Dados;
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
		$Linha = [];
		$Linhas = file(BD_USUARIO);
		$Tam = count($Linhas) -1;

		//Online ou Offline, Foto do Usuário, Ultimo Acesso do Usuário
		for($nCont = 0; $nCont <= $Tam; $nCont++){
			$Linha = explode(';', $Linhas[$nCont]);
			if ($Linha[1] === $Email) {
				if ($Linha[4] === 'On') {
					$Ret[0] = true;
				}
				$Ret[1] = $Linha[5];
				$Ret[2] = str_replace(PHP_EOL, '', $Linha[6]);
				break;
			}			
		}

		return $Ret;
	}	
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: calculaData(Recebe a Data para ser Calculada)
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
			$Ret = "Agora";
		}

		return $Ret;
	}	
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: trataMensagem(Mensagem a ser tratada)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Trata String que será gravada no banco de dados .csv
	--------------------------------------------------------------------------------------------------------------	
	Data: 17/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function trataMensagem($Val){
		$Ret = str_replace(chr(155), "\r\n" , $Val);
		$Ret = str_replace("_", " ", $Ret);
		$Ret = str_replace(';', "'SpS'", $Ret);		
		return $Ret;
	}	
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: destrataMensagem(Mensagem a ser tratada)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retira tratação da string que foi guardada do banco de dados .csv
	--------------------------------------------------------------------------------------------------------------	
	Data: 17/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function destrataMensagem($val){
		$Ret = str_replace("'SpS'", ";", $val);		
		$Ret = str_replace("\r\n", chr(155), $Ret);
		$Ret = str_replace("'SaS'", '_', $Ret);
		return $Ret;
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: atualizaVisto()
	--------------------------------------------------------------------------------------------------------------
	Descrição: Atualiza Visto da mensagem caso usuário viu a mesma.
	--------------------------------------------------------------------------------------------------------------	
	Data: 19/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function atualizaVisto(){
		$nCont = 0;
		$Tam = 0;
		$Linhas = file(BD_MSG);//lÊ TODAS AS LINHAS DO ARQUIVO
		$Linha = [];

		$Tam = count($Linhas) -1;

		for($nCont = $Tam; $nCont >= 0; $nCont--){
			$Linha = explode(';', $Linhas[$nCont]);

			if (isset($Linha[1]) === false) {
				continue;
			}

			$Linha[5] = str_replace(PHP_EOL, '', $Linha[5]);

			if($Linha[5] === 'N' and $Linha[1] != $_SESSION['Email']){
				$Linha[5] = 'S' . PHP_EOL;
				$Linhas[$nCont] = implode(';', $Linha);
			}else if($Linha[5] === 'S' and $Linha[1] != $_SESSION['Email']){
				break;
			}
		}
		//ESCREVE TODAS AS LINHAS DO ARQUVO
		file_put_contents(BD_MSG, $Linhas);
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: validaBloqueado(Recebe o Email do amigo a ser validade)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Valida amigos que estão bloqueados
	--------------------------------------------------------------------------------------------------------------	
	Data: 22/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function validaBloqueado($User, $User2){
	    $Linhas = file(BD_BLOQUEADO);
	    $nCont = in_array($User . ';' . $User2, str_replace(PHP_EOL, '', $Linhas));
	    if ($nCont) {
	        return true;
	    }
	    return false;
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: retornaVisualizacao(Recebe N ou S para validar Visualização)
	--------------------------------------------------------------------------------------------------------------
	Descrição: Retorna a tag responsavel por dizer graficamente se foi visualizado ou não
	--------------------------------------------------------------------------------------------------------------	
	Data: 27/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function retornaVisualizacao($Vizu){
		$Ret = '';

		if($Vizu === 'N'){
			$Ret = '<img src="img/olho_fechado.png" class="img-fluid" width="15" height="15">';
		}else if($Vizu === 'S'){
			$Ret = '<img src="img/olho.png" class="img-fluid" width="15" height="15">';
		}

		return $Ret;	  
	}
	/*
	--------------------------------------------------------------------------------------------------------------	
	Função: chatMorto()
	--------------------------------------------------------------------------------------------------------------
	Descrição: Responsavel por mostrar erro de chat não encontrado para usuário
	--------------------------------------------------------------------------------------------------------------	
	Data: 30/04/2024
	--------------------------------------------------------------------------------------------------------------	
	Programador(A): Ighor Drummond
	--------------------------------------------------------------------------------------------------------------	
	*/	
	function chatMorto($id){
?>
	<div class="rounded border text-center p-1 text-secondary">
		<p>
			Lamentamos informar que o chat que você tentou acessar não está mais disponível. Isso pode ter ocorrido por diversos motivos, incluindo:

			1. O usuário removeu você da lista de amigos.
			2. Houve um erro interno no banco de dados.
			3. É possível que você tenha removido o usuário em outro navegador ou aba enquanto estava na conversa.

			Se o problema persistir, mesmo que o usuário não tenha removido você, por favor, entre em contato conosco através do chat "Administrador do Sistema" para relatar o erro.

			Pedimos desculpas pelo inconveniente causado.

			Atenciosamente,

			Equipe Cube Messenger.
		</p>
		<h6 onclick="tarefa('Sair <?php echo($id); ?>')" class="text-info">Voltar</h6>
	</div>
<?php
		Die();
	}
?>