<?php
	session_start();
	define('BD_AMIGO', '../BDs/bd_listamigos.csv');
	define('BD_USUARIO', '../BDs/bd_usuarios.csv');
	define('BD_ADD', '../BDs/bd_addamigo.csv');
	$Amigos = 0;
	$nLinha = 0;
	$On = 0;
	$Off = 0;
	$nCont = 0;
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
			$Dados[$nCont][2] = $Linha[4];//Recebe o Nome da Conversa do Amigo
			$Dados[$nCont][3] = false;
			$Aux = verificaUsuario($Linha[1]);
			$Dados[$nCont][4] = $Aux[1]; //Recebe a Imagem do Usuário
	
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

	//==========================Funções============================
	//Retorna os dados do usuário exigido para construir o mesmo na lista de amigos
	function verificaUsuario($Email){
		$Ret = [false, ''];

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
				$Ret[1] = str_replace(PHP_EOL, '', $Linha2[5]);
				break;
			}
		}

		fclose($ChaveBanco3);

		return $Ret;
	}	
?>

							<h6 class="text-white">Amigos<span class="badge badge-info">
									<?php echo ($Amigos) ?>
								</span></h6>
							<div class="Amigos-lista d-flex flex-column justify-content-center align-items-center">
								<pre class="w-100 h-100"><!-- Inicio da Lista de Amigos -->
									<ul class="list-group"><!-- Inicio da Lista -->
						<?php
							foreach ($Dados as $Valor) {
						?>
											<li class="list-group-item bg-info text-center w-100" id="<? echo ($Valor[2]) ?>">
												<img src="<? echo ($Valor[4]) ?>" class="border border-dark" align="left">
												<h6 class="d-inline"><? echo ($Valor[0]) ?></h6>
											<?php
												//Valida se o usuário está online
												if ($Valor[3]) {
											?>
														<span class="badge badge-success ">Online</span>
											<?php
												} else {
											?>
														<span class="badge badge-dark ">Offline</span>
											<?php
												}
											?>
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