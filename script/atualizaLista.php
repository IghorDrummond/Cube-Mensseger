<?php
	session_start();

	$nPed = 0;
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_ADD', '../BDs/bd_addamigo.csv');

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
								<input class="btn btn-info p-1 m-1" type="button" onclick="adicionar('Adicionar*<?php echo($Pedidos[$nCont][3]); ?>')" value="Adicionar <?php echo($Pedidos[$nCont][3]); ?>">
								<input class="btn btn-info p-1 m-1" type="button" onclick="adicionar('Recusar*<?php echo($Pedidos[$nCont][3]); ?>')" value="Recusar <?php echo($Pedidos[$nCont][3]); ?>">
							</div>
						</div>
					</fieldset>	
					<?php
						}
					?>