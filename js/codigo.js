//Declaração de Variaveis Globais
//Elementos
var CorpoForm = document.getElementsByClassName('formulario');
var Cubo = document.getElementsByClassName('cubo-face');
var EstruturaCubo = document.getElementsByClassName('cubo');
//Numerico
var nCont2 = 0;
var nCont = 0;
var tamanho = 0;
//Array
var rotacao = [0, 90, -90, 90, 180, -90];//front, back, right, left, top, bottom


//===================================Escopo========================================
CorpoForm[0].style.animation = "sumir 1s";

var Z = setInterval(() =>{
	CorpoForm = document.getElementsByClassName('formulario');
	//Chama função para girar o cubo
	giraCubo();
	clearInterval(Z);
}, 1000);
//===================================Funções=======================================
/*
================================================================
Função: giraCubo()
Descrição: faz a rotação do cubo no Eixo X para insirir o Código
Data: 14/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function giraCubo(){
	var nCont = 0;

	var Y = setInterval(() =>{
		if(nCont === 89){
			clearInterval(Y);
		}

		nCont++;
		EstruturaCubo[0].style.transform = "rotateX(" + nCont.toString() +"deg) rotateY(90deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateX(" + nCont.toString() +"deg) rotateY(90deg)";		
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
function Voltar(){
	var nContY = 90;
	var nContX = 90;

	var Y = setInterval(() =>{
		if(nContX === 1 && nContY === 1){	
			clearInterval(Y);
			//Redireciona para a página de Login
			window.location.href = "login.php";
		}

		nContX--;
		nContY--;
		EstruturaCubo[0].style.transform = "rotateY(" + nContY.toString() +"deg) rotateX("+nContX.toString()+"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + nContY.toString() +"deg) rotateX("+nContX.toString()+"deg)";		
	}, 15);
}
