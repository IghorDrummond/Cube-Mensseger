//Declaração de Variaveis Globais
//Elementos
var CorpoForm = document.getElementsByClassName('formularios');
var EstruturaCubo = document.getElementsByClassName('cubo');
var Tela = document.getElementById('Tela');

/*
================================================================
Função: Fechar()
Descrição: responsavel por fechar a janela pop up de usuario incorreto ou inexistente
Data: 9/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function Fechar(){

	Tela.style.animation = "sumir 1s"
	var P = setTimeout(() =>{
		Tela.style.display = 'none';
		clearTimeout(P);
	}, 1000);
}

/*
================================================================
Função: Voltar()
Descrição: Rotaciona o Cubo novamente para Esquerda para o formulario e Login
Data: 11/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function Voltar(){
	var nCont = -90;

	var Y = setInterval(() =>{
		if(nCont === -1){	
			clearInterval(Y);
			//Redireciona para a página de Login
			window.location.href = "login.php";
		}else if(nCont === -70){
			CorpoForm[0].style.animation = "none";	
			CorpoForm[0].style.webkitAnimation = "none";	
			CorpoForm[0].style.display = "block";
		}

		nCont++;
		EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() +"deg)";		
	}, 15);
}
/*
================================================================
Função: VoltarDir()
Descrição: Rotaciona o Cubo novamente para Direita para o formulario e Login
Data: 12/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function VoltarDir(){
	var nCont = 90;


	var Y = setInterval(() =>{
		if(nCont === 1){	
			clearInterval(Y);
			//Redireciona para a página de Login
			window.location.href = "login.php";
		}else if(nCont === 80){
			CorpoForm[0].style.display = "block";	
			CorpoForm[0].style.animation = "aparecer 2s";
			CorpoForm[0].style.webkitAnimation = "aparecer 2s";
		}
		
		nCont--;
		EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() +"deg)";		
	}, 15);
}
/*
================================================================
Função: Voltar()
Descrição: Rotaciona o Cubo novamente para o formulario e Login
Data: 14/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function VoltarXY(){
	var nCont = 90;

	var Y = setInterval(() =>{
		if(nCont === 1){	
			clearInterval(Y);		
			//Redireciona para a página de Login
			window.location.href = "login.php";
		}else if(nCont === 40){
			CorpoForm[0].style.animation = "aparecer 1s";
			CorpoForm[0].style.webkitAnimation = "aparecer 1s";			
			CorpoForm[0].className = "d-block formularios w-100 m-auto";	
		}
		nCont--;
		EstruturaCubo[0].style.transform = "rotateX(" +  nCont.toString() +"deg) rotateY("+nCont.toString()+"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateX(" +  nCont.toString() +"deg) rotateY("+nCont.toString()+"deg)";		
	}, 15);
}
/*
================================================================
Função: ValidaSenha()
Descrição: Analisa se o Usuário Inseriu os caracteres exigidos
Data: 19/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function ValidaSenha(){
	//Declaração de Variaveis
	//Elementos
	var Lista = document.getElementsByTagName('li');
	var Input = document.getElementsByName('Senha');
	var Cabecalho = document.getElementsByTagName('header');
	//String
	var Carac = "";
	//Array
	var Simbolo = [['ABCDEFGHIJKLMNOPQRSTUVWXYZ'], ['@#_-%¨&;?!$()*><:Ç~´^,.=\/{}`´|[]+""£'] ,['0123456789'] ];
	//Numerico
	var nCont = 0;
	var nCont2 = 0;

	//Liga o Cabeçalho
	Cabecalho[0].style.animation = "aparecer 1s";
	Cabecalho[0].style.webkitAnimation = "aparecer 1s";
	Cabecalho[0].style.display = 'block';

	//Recupera o valor Digitado no Campo Senha
	Carac = Input[0].value;

	//Verifica o Tamanho da Senha
	if((Carac.length +1) >= 8){
		Lista[0].className = "text-success";
	}else{
		Lista[0].className = "text-warning";
	}

	//Verifica os Caracteres existentes dentro da String
	for(nCont = 0; nCont <= Simbolo.length -1; nCont++){
		for(nCont2 = 0; nCont2 <= Simbolo[nCont][0].length -1; nCont2++){
			if( Carac.indexOf(Simbolo[nCont][0].charAt(nCont2)) >= 0 ){
				Lista[nCont +1].className = "text-success";
				break;
			}
			else{
				Lista[nCont +1].className = "text-warning";
			}
		}
	}
}

/*
================================================================
Função: DesligaCabecalho()
Descrição: Desliga o Cabeçalho quando não será mais usado o campo Senha
Data: 19/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function DesligaCabecalho(){
	//Declaração de Variaveis
	//Elementos
	var Cabecalho = document.getElementsByTagName('header');

	Cabecalho[0].style.animation = "sumir 1s";
	Cabecalho[0].style.webkitAnimation = "sumir 1s";
	//Liga o Cabeçalho
	var Z = setTimeout(function(){
		Cabecalho[0].style.display = 'none';
		clearTimeout(Z);	
	}, 1000);
}
	