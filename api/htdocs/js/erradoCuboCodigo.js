//Declaração de Variaveis Globais
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var Inputs = document.getElementsByTagName('input');
//Numerico
var nCont2 = 90;
var nOpc = 1;
//Booleano
var lSaida = false;

//=====================================Escopo==================================
Inputs[4].style.border = '2px solid red';
//Balança o Cubo Negativamente
var x = setInterval(function(){

	if(nCont2 === 15){
		nOpc = 2;
	}else if(nCont2 === -15){
		nOpc = 1;
		lSaida = true;
	}else if(nCont2 === -1 && lSaida){
		clearTimeout(x);
	}

	nCont2 = operacao(nOpc, nCont2);
	EstruturaCubo[0].style.transform = "rotateX(90deg) rotateZ(" + nCont2.toString() +"deg)";
	EstruturaCubo[0].style.webkitTransform = "rotateX(90deg) rotateZ(" + nCont2.toString() +"deg)";
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
			break;
	}

	return lRet;
}
