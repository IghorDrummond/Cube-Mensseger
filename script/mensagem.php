<?php
	//Sessão Atual
	session_start();
	//Declaração de Variaveis
	//String
	$id = $_GET['id'];
	$Mensagem = isset($_GET['Mensagem']) ? $_GET['Mensagem'] : '';
	$ChaveBanco = '';
	//Numerico
	$nLinha = 0;
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_MSG', '../BDs/BD_CONVERSA/'. $id .'.txt');

	//Define o horario 
	date_default_timezone_set('America/Sao_Paulo');

	if(strlen($Mensagem) > 0){
		$ChaveBanco = fopen(BD_MSG, 'a+');
		$Mensagem = trataMensagem($Mensagem);
		$Msg = $_SESSION['Nome'] . ';' . $_SESSION['Email'] . ';' . $Mensagem . ';' .  $_SESSION['FotoPerfil'] . ';' . Date('Y-m-d H:i:s') . PHP_EOL;
		fwrite($ChaveBanco, $Msg);
		fclose($ChaveBanco);
	}

	$Dados = retornaUsuario($id);
	//Constrói o Cabeçalho do Chat
?>
							<div class="d-flex justify-content-between align-items-center bg-white rounded p-2 border sticky-top">
								<img class="rounded-circle border img-fluid" src="<?php echo($Dados[4]); ?>" width="25" height="25">
								<h6><?php echo($Dados[0]); ?></h6>
								<h6 onclick="tarefa('Sair <?php echo($id); ?>')" class="text-info">Voltar</h6>
							</div>

							<div class="d-flex justify-content-between flex-column Conversa_Amigo">
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
		$Classe[0] = 'you';
		$Classe[1] = 'ml-auto';
		$Classe[2] = 'bg-success';		
		if($Linha[0] != $_SESSION['Nome']){
			$Classe[0] = 'amigo';
			$Classe[1] = 'mr-auto';
			$Classe[2] = 'bg-info';
		}
?>
								<blockquote class="<?php echo($Classe[0]); ?> p-2 <?php echo($Classe[1]); ?> <?php echo($Classe[2]); ?> w-50 text-center m-2 ">
									<div class="d-flex alig-items-center justify-content-center">
										<cite class="info text-warning"><?php echo($Linha[0]); ?> -&nbsp</cite>
										<time class="info"><?php print(calculaData($Linha[4])) ?></time>	
									</div>
								  	<p><?php print(destrataMensagem($Linha[2])); ?></p>						  	
								</blockquote>
<?php
	}
?>
							</div><!-- Fim das Mensagens-->						
<?php
	fclose($ChaveBanco);//Fecha arquivo

	if($nLinha === 0){
?>		
	<div class="rounded border text-center p-1 text-info">
		<p>
			Você e <?php echo($Dados[0]); ?> não tem uma conversa ainda. Mande um 'Oi' para conversar.
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
				break;
			}
		}

		fclose($ChaveBanco);

		return $Dados;
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
			$Ret = "Agora Pouco";
		}

		return $Ret;
	}	

	function trataMensagem($Val){
		$Ret = str_replace(chr(155), "\r\n" , $Val);
		$Ret = str_replace("_", " ", $Ret);
		$Ret = str_replace(';', "'SpS'", $Ret);		
		return $Ret;
	}	

	function destrataMensagem($val){
		$Ret = str_replace("'SpS'", ";", $val);		
		$Ret = str_replace("\r\n", chr(155), $Ret);
		$Ret = str_replace("'SaS'", '_', $Ret);
		return $Ret;
	}

?>