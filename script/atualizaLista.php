<?php
	session_start();

	$nPed = 0;
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_ADD', '../BDs/bd_addamigo.csv');

	//================Valida Pedidos de Amizades caso existir para o usuário logado ====================
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
	
	//==========================Funções============================

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

			<pre class="pre_amigos my-2">
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