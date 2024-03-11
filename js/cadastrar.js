//Declaração de Variaveis Globais
//Elementos
var CorpoForm = document.getElementsByClassName('formularios');
var EstruturaCubo = document.getElementsByClassName('cubo');

//===================================Escopo========================================
CorpoForm[0].style.animation = "sumir 1s";
CorpoForm[0].style.webkitAnimation = "sumir 1s";
var Z = setInterval(() =>{
	CorpoForm[0].style.display = "none";
	//Chama função para girar o cubo
	giraCubo();
	clearInterval(Z);
}, 1000);
//===================================Funções=======================================
/*
================================================================
Função: giraCubo()
Descrição: faz a rotação do cubo para o formulario existente
Data: 11/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function giraCubo(){
	var nCont = 0;

	var Y = setInterval(() =>{
		if(nCont === -89){
			clearInterval(Y);
		}

		nCont--;
		EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() +"deg)";		
	}, 15);

}
