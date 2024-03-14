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
EstruturaCubo[0].style.transform = "rotateY(90deg)";
CorpoForm[0].style.animation = "sumir 1s";
CorpoForm[0].style.webkitAnimation = "sumir 1s";

var Z = setInterval(() =>{
	//CorpoForm[0].style.display = "none";
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
		if(nCont === -1){	
			clearInterval(Y);
			//Redireciona para a página de Login
			window.location.href = "login.php";
		}else if(nCont === -70){
			CorpoForm[0].style.display = "block";
			CorpoForm[0].style.animation = "aparecer 2s";	
			CorpoForm[0].style.webkitAnimation = "aparecer 2s";	
		}

		nCont++;
		console.log(nCont);
		EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() +"deg)";		
	}, 15);
}
