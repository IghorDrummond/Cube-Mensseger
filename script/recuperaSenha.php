<?php
	//Importar Bibliotecas para Email
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require_once('Exception.php');
	require_once('SMTP.php');
	require_once('PHPMailer.php');
	//Inicia a Sessão Global
	session_start();
	//Declaração das Variaveis Globais
	//String
	$Info = $_POST['Info'];
	$ChaveBanco = "";
	$Nome = "";
	$Menssagem = "";
	$Codigo = "";
	$KeyCod = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890#_@%;";
	$ChaveBanco = "";
	//Data
	$DataHoje = null;
	//Array
	$Nova_Linha = array();
	//Numerico
	$nCont = 0;
	//Constantes
	define('BD_USUARIO', '../BDs/bd_usuarios.txt');	
	define('BD_CODIGO', '../BDs/bd_codigos.txt');

	//Valida se existe o usuario no banco de dados
	$Dados = verificaExistencia($Info);

	if($Dados[0]){	
		//Gera o Código a ser enviado
		for($nCont = 0; $nCont <= 7; $nCont++){
			$Codigo .= substr($KeyCod, random_int(0, 39), 1);
		}
		//Define o horario 
		date_default_timezone_set('America/Sao_Paulo');
		//Define data atual
		$DataHoje = date('Y-m-d H:i:s');
		//Abre Banco de Dados para Leitura e Escrita
		$ChaveBanco = fopen(BD_CODIGO, 'a+');
		//Escreve Novo Código no Banco de Dados
		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));

			if (isset($Linha[1]) === false) {
				continue;
			}

			if($Linha[0] != $Dados[1]){
				$Nova_Linha[$nCont] = implode(';', $Linha);
			}else{
				$Nova_Linha[$nCont] = $Linha[0] .';'. $Codigo  .';'. strtotime($DataHoje) . PHP_EOL;
			}

			$nCont++;
		}
		//Fecha o Banco de Dados
		fclose($ChaveBanco);
		//Deleta o Arquivo Anterior
		unlink(BD_CODIGO);
		//Cria um Novo Banco
		$ChaveBanco = fopen(BD_CODIGO, 'x+');
		//Escreve os Novos Dados no Arquivo
		for($nCont = 0; $nCont <= count($Nova_Linha) -1; $nCont++){
			fwrite($ChaveBanco, $Nova_Linha[$nCont]);
		}	
		//Envia o Email para Usuário
		EnviaEmail($Dados[1] , $Dados[2], $Codigo);
	}else{
		$_SESSION['Erro'] = 'NotEmail';
	}


//===============================Função==========================

	function verificaExistencia($Email){
		$aRet = [false, '', ''];
		//Abre o Banco para leitura
		$ChaveBanco = fopen(BD_USUARIO, 'r');

		while (!feof($ChaveBanco)) {
			$Linha = explode(';', fgets($ChaveBanco));
			
			if(isset($Linha[1]) === false){
				continue;
			}

			if($Linha[1] === $Email OR strtoupper($Linha[3]) === strtoupper($Email)){
				$aRet[0] = true;
				$aRet[1] = $Linha[1];
				$aRet[2] = $Linha[3];
				break;
			}
		}	
		//Fecha Banco de Dados
		fclose($ChaveBanco);
		//Retorna dados 
		return $aRet;	
	}

	function EnviaEmail($Email, $Nome, $Codigo){
		//Inicia o Envio do Email
		$mail = new PHPMailer(true);

		try {
			//Configuarações do Servidor
			//$mail->SMTPDebug = 2; 
			$mail->isSMTP();                                            
			$mail->SMTPAuth   = true;                                   
			$mail->Username   = 'seuemail';                     
			$mail->Password   = 'suasenha';                               
			$mail->SMTPSecure = 'tls';            
			$mail->SMTPAutoTLS = false;
			$mail->SMTPOptions = array(
			    'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
			);
			$mail->CharSet="UTF-8";
			$mail->Host       = 'smtp.email.com';                     
			$mail->Port       = 587;
			//Destinatário e Remetente
			$mail->setFrom('seuemail', 'Nao Responda - Código');
			$mail->addAddress($Email, $Nome);     

			//Corpo do Email
			$mail->isHTML(true);                                  
			$mail->Subject = 'Nao Responda';
			$mail->Body    = MontaCorpo($Codigo, $Nome);
			$mail->AltBody = 'Este é o seu Código para Recuperar a Senha: ' . $Codigo;
			//Envio do Email
			$mail->send();
		} catch (Exception $e) {
			echo "Email não foi Enviado, ocorreu problema: {$mail->ErrorInfo}";
		}			
	}

	function MontaCorpo($Codigo, $Nome){
		$Ret = '';

		$Ret = '
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Cube Mensseger</title>
			<style type="text/css">
				* {
					padding: 0;
					margin: 0;
				}

				header {
					height: 10vh;
					background: blue;
					text-align: center;
					color: white;
					padding: 15px;
					-webkit-box-sizing: border-box;
					        box-sizing: border-box;
				}
				header>h1{
					margin: auto;
				}
				section>h1{
					background: gray;
					letter-spacing: 15px;
					width: 50%;
					margin: 25px auto;
					color: white;
				}
				section, footer, header{
					text-align: center;
					font-family: arial;
					padding: 25px;
					-webkit-box-sizing: border-box;
					        box-sizing: border-box;
				}
				footer{
					margin-top: 35px;
				}
			</style>
		</head>

		<body>
			<header>
				<h1>Cube Mensseger</h1>
			</header>
			<main>
				<section>
					<h3>Olá! '. $Nome .'</h3>
					<h1>'. $Codigo .'</h1>
				</section>
				<section>
					<p>
						<strong>Atenção usuário:</strong><br> Ao receber um código de segurança para trocar sua senha, tenha
						cautela. Mantenha o código privado e não o compartilhe com ninguém. Verifique sempre a autenticidade da
						fonte antes de inserir o código. Sua segurança é primordial.<br><br>
						A segurança da senha é fundamental para proteger nossas informações pessoais e manter nossa privacidade
						online. Aqui estão algumas razões pelas quais a segurança da senha é tão importante:
						<br><br> Proteção de Dados Pessoais: Senhas fortes ajudam a proteger nossas informações pessoais, como
						dados bancários, endereços, histórico de compras e comunicações privadas. Sem uma senha segura, essas
						informações podem ser facilmente acessadas por pessoas não autorizadas.
						<br><br> Prevenção contra Acesso Não Autorizado: Uma senha forte é a primeira linha de defesa contra
						hackers e cibercriminosos que tentam acessar nossas contas online. Se nossas senhas forem fracas ou
						fáceis de adivinhar, nossa conta se torna vulnerável a ataques de força bruta, phishing e outras
						técnicas de hacking.
						<br><br> Evitar Roubos de Identidade: Senhas seguras ajudam a evitar o roubo de identidade, onde alguém
						pode usar nossas informações pessoais para se passar por nós e cometer fraudes em nosso nome. Uma senha
						forte dificulta a tentativa de roubo de identidade e protege nossa reputação online.
						<br><br> Manter a Confidencialidade: Senhas são usadas para proteger informações confidenciais, como
						dados comerciais, propriedade intelectual e segredos comerciais. Sem uma senha forte, essas informações
						podem ser expostas e comprometer a competitividade e a segurança de uma organização.
						<br><br> Preservar a Segurança Financeira: Muitos serviços online estão vinculados a contas bancárias e
						cartões de crédito. Uma senha segura é essencial para proteger nossas finanças e evitar que criminosos
						acessem e abusem de nossos fundos.
						<br><br> Garantir a Integridade das Comunicações: Senhas protegem nossas contas de e-mail, mensagens e
						redes sociais, garantindo que apenas pessoas autorizadas possam acessar nossas comunicações privadas.
						Isso é especialmente importante para manter a confiança e a privacidade em relacionamentos pessoais e
						profissionais.
						<br><br> Em resumo, a segurança da senha desempenha um papel crucial na proteção de nossas informações
						pessoais, financeiras e profissionais. Portanto, é essencial criar e manter senhas fortes e únicas para
						cada uma de nossas contas online.
					</p>
				</section>
			</main>
			<footer>
				<h5>Desenvolvido Por Ighor Drummond</h5>
			</footer>
		</body>
		';

		return $Ret;
	}	
?>