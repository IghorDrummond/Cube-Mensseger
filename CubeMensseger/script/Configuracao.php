<?php
	//Iniciando Sessão
	session_start();
	//Declaração de Variaveis 
	//String
	$Acao = $_GET['Opc'];
	//Constantes
	define('BD_USUARIO', '../../CubeMensseger/BDs/bd_usuarios.csv');
	define('BD_BLOQUEADO', '../../CubeMensseger/BDs/bd_bloqueado.csv');
	define('BD_AMIGO', '../../CubeMensseger/BDs/bd_listamigos.csv');
	define('BD_ADD', '../../CubeMensseger/BDs/bd_addamigo.csv');
	define('SV_IMG', '../img/');
	define('BYTES', 500000);

	switch($Acao){
		case 'Foto':
			trocaFoto();
			break;
		case 'Senhas':
			trocaSenhas($_GET['Senha'], $_GET['ConfirmaSenha']);
			break;
		case 'Bloqueado':
			bloqueado($_SESSION['Email'], 'N');	
			break;
		case 'Nome':
			atualizaNome($_SESSION['Email'], $_SESSION['Nome']);
			break;
		default:
			break;
	}

//============================Funções===================================
	function trocaFoto(){
		$Linhas = [];
		$Linha = [];    
		$Ret = true;
		$Log = 'Foto salva com sucesso! Sua página será recarregada após 5 segundos...';

		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {
			// Verifica se o arquivo foi enviado sem erros
			if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0){
				// Pasta onde a foto será armazenada
				$destino = SV_IMG;
				// Obtém o nome do arquivo e seu caminho temporário
				$Imagem = $_FILES["foto"]["name"];
				$caminho_temporario = $_FILES["foto"]["tmp_name"];
				//Valida o Tamanho da Foto Enviada
				if ($_FILES["foto"]["size"] > BYTES) {
					$Ret = false;
					$Log = "Desculpe, o tamanho da imagem é muito grande.";
				}else{
					//Valida o Formato da Imagem Permitidas
					if(in_array(strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION)), array("jpg", "jpeg", "png", "gif"))){
						// Move o arquivo para o diretório de destino
						if (!move_uploaded_file($caminho_temporario, $destino . $Imagem)) {
							$Ret = false;
							$Log = "Erro ao salvar a foto.";
						}else{
							$_SESSION['FotoPerfil'] = substr(SV_IMG, 3, strlen(SV_IMG)) . $Imagem;
						}
					}else{
						$Ret = false;
						$Log = "O arquivo não é uma imagem válida.";						
					}
				}
			}else{
				$Ret = false;
				$Log =  "Desculpe, ocorreu um erro ao fazer o upload do arquivo.";			
			} 
		}

		if(!$Ret){
			Error($Log);
			return null;
		}

		$Linhas = file(BD_USUARIO);

		foreach($Linhas as $i => $Valor){
			$Linha = explode(';', $Valor);

			if (isset($Linha[1]) === false) {
				continue;
			}

			if($_SESSION['Email'] === $Linha[1] and $_SESSION['Nome'] === $Linha[3]){
				$Linha[5] = substr(SV_IMG, 3, strlen(SV_IMG)) . $Imagem;
				$Linhas[$i] = implode(';', $Linha);
				break;
			}
		}

		//ESCREVE TODAS AS LINHAS DO ARQUVO
		file_put_contents(BD_USUARIO, $Linhas);

		sucesso($Log);
	}	

	function trocaSenhas($Senha, $Csenha){
		$Linhas = [];
		$Linha = [];


		if($Senha != $Csenha){
			Error("Senhas não se correspondem!");
			return  null;
		}

		sucesso('A senha foi alterada com sucesso!');
	}

	function bloqueado($Email){
		$Linhas = file(BD_BLOQUEADO);
		$Linha = [];
		//Booleano
		$lTem = false;
		cabec();

		foreach($Linhas as $i => $Valor){
			$Linha = explode(';', $Valor);

			if (isset($Linha[1]) === false) {
				continue;
			}

			$Linha[0] === $Email ? $lTem = imprime(verificaUsuario(str_replace(PHP_EOL, '', $Linha[1]))) : '';
		}

		if(!$lTem){
			naoTem();
		}
	}	

	function verificaUsuario($Email){
		$Ret = [];
		$Linhas = file(BD_USUARIO);

		foreach($Linhas as $Valor){
			$Linha = explode(';', $Valor);

			if (isset($Linha[1]) === false) {
				continue;
			}

			if ($Linha[1] === $Email) {
				$Ret[0] = $Linha[5];//Foto do usuário
				$Ret[1] = $Linha[3];//Nome do Usuário
				$Ret[2] = $Linha[1];//Retorna o Email do usuário
				break;
			}
		}
		return $Ret;
	}	

	function atualizaNome($Email, $NomeSession){
		$Const = [BD_USUARIO, BD_ADD, BD_AMIGO];
		$NumLinha = [[1,3], [1,2], [1,2]];
		$NomeNew = (trim(strtoupper($_GET['Nome'])) . ' ' . trim(strtoupper($_GET['Sobrenome'])));
		//Atualiza a Lista de Usuário e Pedidos de Amizade
		for($nCont = 0; $nCont <= 2; $nCont++){
			atualizaDados($Email, $NomeSession, ($nCont === 1 ? $NomeNew . PHP_EOL : $NomeNew), $NumLinha[$nCont][0], $NumLinha[$nCont][1], $Const[$nCont]);		
		}
		//Atualiza as Conversas
		$Linhas = file($Const[2]);
		foreach ($Linhas as $i => $Valor) {
			$Linha = explode(';', $Valor);
			if(isset($Linha[1]) === false){
				continue;
			}
			if($Linha[0] === $Email){
				$Banco = '../../CubeMensseger/BDs/BD_CONVERSA/'. $Linha[3];
				$Linhas2 = file($Banco);
				foreach($Linhas2 as $j => $Conv){
					$Linha2 = explode(';', $Conv);

					if(isset($Linha2[1]) === false){
						continue;
					}

					if($Linha2[1] === $Email){
						$Linha2[0] = $NomeNew;
						$Linhas2[$j] = implode(';', $Linha2); 
					}
				}
				//ESCREVE TODAS AS LINHAS DO ARQUVO
				file_put_contents($Banco, $Linhas2);
			}
		}
		//Atualiza os Dados da Sessão Atual
		$_SESSION['Nome'] = $NomeNew;
		//Retorna Sucesso ao usuário após a troca de Nome.
		sucesso('Nome Atualizado com Sucesso! Página irá atualizar em 5 Segundos...');
	}

	function atualizaDados($Email, $NomeAnt, $NomeAtu, $PosicIni, $PosicFinal, $Banco){
		$Linhas = file($Banco);
		$Linha = [];

		foreach ($Linhas as $i => $Valor) {
			$Linha = explode(';', $Valor);
			if(isset($Linha[1]) === false){
				continue;
			}
			if($Linha[$PosicIni] === $Email){
				$Linha[$PosicFinal] = $NomeAtu;
				$Linhas[$i] = implode(';', $Linha); 
			}
		}

		//ESCREVE TODAS AS LINHAS DO ARQUVO
		file_put_contents($Banco, $Linhas);
	}

	function Error($Log){
?>
		<div class="alert alert-danger alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Ocorreu um Problema!</strong> <?php echo($Log) ?></a>
		</div>	
<?php
	}
?>
<?php
	function sucesso($Log){
?>
		<div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Operação Concluída!</strong> <?php echo($Log) ?></a>
		</div>	
<?php
	}

	function imprime($V){
?>
		<div class="bg-warning w-75 rounded m-auto">
			<img src="<?php echo ($V[0]); ?>" class="img-fluid border border-dark" width="70" height="70">
			<h6 class="text-dark"><i style="color: black;"><?php echo(ucfirst(strtolower($V[1])));?></i> Está bloqueado.</h6>
			<button class="btn btn-info rounded my-2 w-" onclick="tarefa('Desbloquear <?php echo ($V[2]); ?>')">Desbloquear <?php echo($V[1]); ?></button>
		</div>
<?php
		return true;
	}
	function cabec(){
?>
	<h6>Desbloqueie Pessoas:</h6>
<?php
	}
	function naoTem(){
?>	
	<h6>Não há nenhum usuário bloqueado por enquanto...</h6>
<?php
	}
?>