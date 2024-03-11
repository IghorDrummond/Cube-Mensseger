//Declaração de Variaveis Globais
//Elementos
var CorpoForm = document.getElementsByClassName('formularios');

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
Função: 
Descrição: faz subtração ou adição de acordo com a opção matemática
Data: 11/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function giraCubo(){
	var Y = setTimeout(() =>{
		
	}, 25);
}
