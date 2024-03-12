//Declaração de Variaveis Globais
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var Cubo = document.getElementsByClassName('cubo-face');
var tela = document.getElementById('Tela');
var Inputs = document.getElementsByTagName('input');
//Numerico
var nCont = 0;
var nOpc = 1;
//Booleano
var lSaida = false;

//=====================================Escopo==================================
//Deixa os Inputs em Vermelho
Inputs[0].style.border = "1px solid red";
Inputs[1].style.border = "1px solid red";

//Balança o Cubo Negativamente
var x = setInterval(function(){

	if(nCont === 15){
		nOpc = 2;
	}else if(nCont === -15){
		nOpc = 1;
		lSaida = true;
	}else if(nCont === -1 && lSaida){
		clearTimeout(x);
	}

	nCont = operacao(nOpc, nCont);
	EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() +"deg)";
	EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() +"deg)";
},25);

//===================================Funções=======================================
/*
================================================================
Função: operacao(opção matemática, valor a ser alterado)
Descrição: faz subtração ou adição de acordo com a opção matemática
Data: 11/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function operacao(nOpc, valor){
	var lRet = valor;

	switch(nOpc){
		case 1:
			lRet += 1;
			break;
		default:	
			lRet -= 1;
	}

	return lRet;
}
