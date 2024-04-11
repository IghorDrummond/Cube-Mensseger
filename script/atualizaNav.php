<?php
	session_start();
	//Declaração de Variaveis
	//String
	$ChaveBanco = '';
	//Array
	$Linha = [];
	//Numericos
	$nPed = 0;
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_ADD', '../BDs/bd_addamigo.csv');

	//================Valida Pedidos de Amizades caso existir para o usuário logado ====================
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
?>

						<i class="fa-regular fa-address-book fa-xl">
							<span id="lista_amigos" class="badge badge-pill badge-success"><?php echo($nPed); ?></span>
						</i>