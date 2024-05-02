<?php
    session_start();	

    if(isset($_SESSION['Login'])){
        if($_SESSION['Login'] === false){
            header('Location: login.php');
            exit; // Adicionando exit para garantir que o script seja encerrado após o redirecionamento
        } else if($_SESSION['Login']) {
            // A função verificaOnline($_SESSION['Email']) retorna false, então não é necessário verificar a condição
            if(verificaOnline($_SESSION['Email']) === false) {
                header('Location: login.php');
                exit; // Adicionando exit para garantir que o script seja encerrado após o redirecionamento
            }
        }
    }else{
        header('Location: login.php');
        exit;
    }

	//==================Funções==========================
	function verificaOnline($Email){
		$Dir = '../CubeMensseger/BDs/bd_usuarios.csv';
		$lRet = true;

		$ChaveBanco = fopen($Dir, 'r');
		
		while(!feof($ChaveBanco)){
			$Linha = explode(';', fgets($ChaveBanco));

			if(isset($Linha[1]) === false){
				continue;
			}
			
			if($Linha[1] === $Email){
				if($Linha[4] === 'Off'){
					$lRet = false;
					$_SESSION['Login'] = false;
				}
				break;
			}
		}
		//Fecha o Arquivo 
		fclose($ChaveBanco);
		//Retorna Booleano
		return $lRet;
	}

?>