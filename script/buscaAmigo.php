<?php
	session_start();
	//Declaração de Variavel
	//String
	$Pesquisa = $_GET['Nome'];
	$ChaveBanco = '';
	//Numerico
	$nCont = 0;
	//Array
	$Linha = [];
	$Amigo = [];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');

//========================Escopo===========================
	$ChaveBanco = fopen(BD_USUARIO, 'r');

	while (!feof($ChaveBanco)) {
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}

		if(verificaAmigo($Linha[3], $Pesquisa)){
			$Amigo[$nCont][0] = $Linha[1];//Email
			$Amigo[$nCont][1] = $Linha[3];//Nome
			$Amigo[$nCont][2] = str_replace(PHP_EOL, '', $Linha[5]);//Foto
			$nCont++;
		}
	}
	//Fecha Leitura do Arquivo
	fclose($ChaveBanco);
	//Valida se os amigos buscados já estão adicionados
	//Abre o arquivo para leitura
	$ChaveBanco = fopen(BD_AMIGO, 'r');
	//Percorre o arquivo aberto
	$nCont = 0;
	while(!feof($ChaveBanco)){
		$Linha = explode(';', fgets($ChaveBanco));

		if(isset($Linha[1]) === false){
			continue;
		}
		
		if($Linha[0] === $_SESSION['Email']){
			//Caso o Amigo procurado já existir na lista de amigos com o mesmo usuário, ele deleta da busca
			for($nCont = 0; $nCont <= count($Amigo)-1; $nCont++){
				if($Linha[1] === $Amigo[$nCont][0] or $Linha[0] === $Amigo[$nCont][0]){
					unset($Amigo[$nCont]);//
					$Amigo = array_values($Amigo);//Organiza a matriz após deletação do Indice
				}
			}
		}
	}
	//Fecha Leitura do Arquivo
	fclose($ChaveBanco);
	//Devolve os Valores para a página de adicionar Amigos
//============================Funções=================================
	function verificaAmigo($Nome, $Busca){
		//Declaração de variaveis
		//String
		$Len = 0;
		//Numerico
		$Acertos = 0;
		$nCont2 = 0;
		//Booleano
		$Ret = false;

		$Busca = strtoupper(str_replace(' ', '', $Busca));
		$Nome = strtoupper(str_replace(' ', '', $Nome));
		$Len = strlen($Busca);
		//Verifica se teve acertos
		for($nCont = 0; $nCont <= strlen($Nome)-1; $nCont++){

			//Caso tiver apenas uma letra na busca, só será valido aquele usuário que tiver a mesma letra inicial
			if(strlen($Busca) === 1 and $Acertos === 0 and $nCont === 1){
				break;
			}	

			if($Busca[$nCont2] === $Nome[$nCont]){
				$nCont2++;
				$Acertos++;
			}else{
				$nCont2 = 0;
				$Acertos = 0;
			}	

			//Valida os Acertos
			if($Acertos === $Len){
				$Ret = true;
				break;
			}
		}
		return $Ret;
	}
?>
									<ul class="list-group">
									<?php
										if(isset($Amigo[0][1])){
									?>	
									<span id="lista_amigos" class="badge badge-pill badge-success sticky-top">Encontrados: <?php echo($nCont); ?></span>
									<?php			
															
											for($nCont = 0; $nCont <= count($Amigo) -1; $nCont++){
									?>
										<li class="list-group-item bg-info text-center w-100 d-flex justify-content-between align-items-center" id="<? echo ($Amigo[$nCont][1]); ?>">
											<img src="<? echo ($Amigo[$nCont][2]); ?>" class="border border-dark" align="left">
											<h6 class="d-inline"><? echo ($Amigo[$nCont][1]); ?></h6>
											<button class="btn btn-success d-flex justify-content-center align-items-center p-3 border border-dark" onclick="adicionar('<?php echo($Amigo[$nCont][1]) ?>')">
												<i class="fa-solid fa-user-plus fa-lg" style="color: black;"></i>
											</button>
										</li>
									<?php	
											}										
										}
									?>
									</ul>