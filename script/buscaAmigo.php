<?php
	session_start();
	//Declaração de Variavel
	//String
	$Pesquisa = $_GET['Nome'];
	$ChaveBanco = '';
	//Numerico
	$nCont = 0;
	$nCont2 = 0;
	//Array
	$Linha = [];
	$Amigo = [];
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_BLOQUEADO', '../BDs/bd_bloqueado.csv');	
//========================Escopo===========================
	$Linhas = file(BD_USUARIO);
	//Busca pelo Nome procurado.
	for($nCont = 0; $nCont <= count($Linhas) -1; $nCont++){
		$Linha = explode(';', $Linhas[$nCont]);

		if(isset($Linha[1]) === false){
			continue;
		}		

		if(verificaAmigo($Linha[3], $Pesquisa)){	
			$Amigo[$nCont2][0] = $Linha[1];//Email
			$Amigo[$nCont2][1] = $Linha[3];//Nome
			$Amigo[$nCont2][2] = str_replace(PHP_EOL, '', $Linha[5]);//Foto
			$nCont2++;
		}
	}
	//Valida se os amigos buscados já estão adicionados
	$Linhas = file(BD_AMIGO);
	$nCont2 = 0;
	for($nCont = 0; $nCont <= count($Linhas) -1; $nCont++){
		$Linha = explode(';', $Linhas[$nCont]);

		if(isset($Linha[1]) === false){
			continue;
		}	
		
		if($Linha[0] === $_SESSION['Email']){
			//Caso o Amigo procurado já existir na lista de amigos com o mesmo usuário, ele deleta da busca
			for($nCont2 = 0; $nCont2 <= count($Amigo)-1; $nCont2++){
				if($Linha[1] === $Amigo[$nCont2][0] or $Linha[0] === $Amigo[$nCont2][0]){
					unset($Amigo[$nCont2]);//
					$Amigo = array_values($Amigo);//Organiza a matriz após deletação do Indice
				}
			}
		}		
	}
	//Valida se há usuários bloqueados pelo buscador
	for($nCont = 0; $nCont <= count($Amigo)-1; $nCont++){
		if(validaBloqueado($_SESSION['Email'], $Amigo[$nCont][0]) or validaBloqueado($Amigo[$nCont][0], $_SESSION['Email'])){
			unset($Amigo[$nCont]);//
			$Amigo = array_values($Amigo);//Organiza a matriz após deletação do Indice
		}
	}
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
?>
									<ul class="list-group">
									<?php
										if(isset($Amigo[0][1])){
									?>	
									<span id="lista_amigos" class="badge badge-pill badge-success sticky-top">Encontrados: <?php print(count($Amigo)); ?></span>
									<?php			
															
											for($nCont = 0; $nCont <= count($Amigo) -1; $nCont++){
									?>
										<li class="list-group-item bg-info text-center w-100 d-flex justify-content-between align-items-center" id="<? echo ($Amigo[$nCont][1]); ?>">
											<img src="<? echo ($Amigo[$nCont][2]); ?>" class="border border-dark" align="left">
											<h6 class="d-inline"><? echo (ucfirst(strtolower($Amigo[$nCont][1]))); ?></h6>
											<button class="btn btn-success d-flex justify-content-center align-items-center p-3 border border-dark" onclick="adicionar('<?php echo($Amigo[$nCont][0]) ?>')">
												<i class="fa-solid fa-user-plus fa-lg" style="color: black;"></i>
											</button>
										</li>
									<?php	
											}										
										}
									?>
									</ul>