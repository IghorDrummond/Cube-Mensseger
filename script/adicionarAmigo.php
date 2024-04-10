<?php
	session_start();
	//Declaração de Variaveis Globais
	//String
	$Nome = $_GET['Nome'];
	$ChaveBanco = "";
	$Validacao = "";
	//Constante
	define('BD_ADD', '../BDs/bd_addamigo.csv');
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_NUM', '../BDs/bd_num.csv');
	define('BD_CONVERSA', '../BDs/BD_CONVERSA');


	$Nome = str_replace('*', ' ', $Nome);
	#Valida se é um pedido de aceitaçção ou Recusa
	if(strpos($Nome, 'Adicionar') === 0 or strpos($Nome, 'Recusar') === 0){
		$Vld = substr($Nome, 0, strpos($Nome, ' '));#Recebe a Validação da Operação
		$Nome = substr($Nome, (strpos($Nome, ' ') +1), (strlen($Nome)));#Recebe o Nome do Usuário
		switch($Vld){
			case 'Adicionar':
				$Validacao = adicionaAmigo($Nome);
				break;
			default:
				recusaAmigo($Nome);
				break;
		}
	}#Valida se o Usuário já enviou esta mesma solicitação
	else if(verificaAmigo($Nome) === false){
		$ChaveBanco = fopen(BD_ADD, 'a+');
		//Primeiro Email é o que recebeu o convite, o segundo é o que enviou, terceiro é o nome de quem enviou
		fwrite($ChaveBanco, $Nome . ';' . $_SESSION['Email'] . ';' . $_SESSION['Nome'] . PHP_EOL );
		fclose($ChaveBanco);
		$Validacao = 'Envio';
		
	}else{
		//Caso a solicitação já foi enviada para o usuário, será retornado que o envio já foi feito
		$Validacao = 'Add';
	}		
//=================================Funções========================	
	function verificaAmigo($Nome){
		$Ret = false;

		$ChaveBanco = fopen(BD_ADD, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if($Nome === $Linha[0] and $Linha[1] === $_SESSION['Email']){
				$Ret = true;
				break;
			}
		}

		fclose($ChaveBanco);

		return $Ret;
	}
	function adicionaAmigo($Nome){
		//Declaração de Variaveis
		//String
		$NumC = '';
		//Array
		$Novo = [];
		$Linha = [];
		$Nova_Linha = [''];
		$ChaveBanco = "";
		//Numerico
		$nCont = 0;
		//Data
		$Data = null;
		
		#Procura Convite enviado pelo Usuário
		$ChaveBanco = fopen(BD_ADD, 'r');

		while(!feof($ChaveBanco)){
			$Linha = explode(';', fgets($ChaveBanco));

			if(isset($Linha[1]) === false){
				continue;
			}
			$Linha[2] = str_replace(PHP_EOL, '', $Linha[2]);
			$Aux[0] = strtoupper(str_replace(' ', '', $Linha[0]));
			$Aux[1] = strtoupper(str_replace(' ', '', $Linha[2]));

			if($Aux[0] === strtoupper(str_replace(' ', '', $_SESSION['Nome'])) and $Aux[1] === strtoupper(str_replace(' ', '', $Nome))){
				$Novo[0] = $Linha[1];
				$Novo[1] = $_SESSION['Email'];
			}else{
				$Nova_Linha[$nCont] = implode(';', $Linha);
				$nCont++;
			}
		}
		fclose($ChaveBanco);

		//Escreve todos os dados deletando o convite anterior
		$ChaveBanco = fopen(BD_ADD, 'w+');
		for($nCont = 0; $nCont <= count($Nova_Linha) -1; $nCont++){
			fwrite($ChaveBanco, $Nova_Linha[$nCont] . PHP_EOL);
		}
		fclose($ChaveBanco);			

		//Define a Data do Sistema
		date_default_timezone_set('America/Sao_Paulo');
		$Data = date('d/m/Y');
		$NumC = retornaNumero();
		//Criar Amizade no arquivo lista de amigos
		$Novo[2] = $Novo[0] . ';' . $Novo[1] . ';' . $_SESSION['Nome'] . ';' . $NumC . ';' . $Data . PHP_EOL;
		$Novo[3] = $Novo[1] . ';' . $Novo[0] . ';' . $Nome . ';' . $NumC . ';' . $Data . PHP_EOL;
		//Escreve a nova Amizade na Lista
		$ChaveBanco = fopen(BD_AMIGO, 'a+');
		fwrite($ChaveBanco, $Novo[2]);
		fwrite($ChaveBanco, $Novo[3]);
		//Fecha arquivo 
		fclose($ChaveBanco);

		//Criar o Banco de Conversa
		$ChaveBanco = fopen(BD_CONVERSA ."/$NumC.txt", 'x');
		//Fecha arquivo 
		fclose($ChaveBanco);
		return 'Aceito';	
	}

	function retornaNumero(){
		$ChaveBanco = fopen(BD_NUM, 'r+');
    	// Move o ponteiro para a penúltima linha
    	fseek($ChaveBanco, -1, SEEK_END);
		$Ret = fgets($ChaveBanco);
		$Ret = strval((intval($Ret) + 1));
		fseek($ChaveBanco, 0, SEEK_END);
		fwrite($ChaveBanco, PHP_EOL. $Ret );
		fclose($ChaveBanco);
		return $Ret;
	}

?>


	<?php
			if($Validacao === 'Envio'){
	?>	
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>Pedido Enviado!</strong> Pedido de Amizade Enviado com Sucesso!</a>
		</div>	
	<?php
			}
			if($Validacao === 'Add'){ 
	?>
		<div class="alert alert-danger alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>Pedido não Enviado!</strong> Pedido de Amizade já foi enviado para este usuário.</a>
		</div>				
		<?php
			}
			if($Validacao === 'Aceito'){ 
	?>
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
  			<strong>Pedido Aceito!</strong> Pedido de Amizade foi Aceito com Sucesso!</a>
		</div>	
	<?php
			}
	?>	