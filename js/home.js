//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var barra = document.getElementsByClassName('progress-bar');
var porcentagem = document.getElementById('Loading');
var Carregamento = document.getElementById('Carregamento');
var Navegacao = document.getElementsByTagName('header');

//===================================Escopo=========================================
carregamento();

//===================================Funções=========================================
function carregamento(){
	var nCont = 20;
	var nCont2 = 0;


	var Z = setInterval(() =>{
		nCont += 20;
		nCont2 -= 90;

		EstruturaCubo[0].style.transform = "rotateY(" + (nCont2).toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + (nCont2).toString() +"deg)";

		if(nCont > 100){
			clearInterval(Z);
			Carregamento.className = 'd-none';
			Navegacao[0].className = 'd-block w-100 bg-light my-1 p-1';
			EstruturaCubo[0].style.transform = "rotateY(0deg)";
			EstruturaCubo[0].style.webkitTransform = "rotateY(0deg)";		
		}else if(nCont2 <=  360){
			barra[0].style.width = nCont.toString() + '%';
			porcentagem.textContent = nCont.toString() + '%';

			EstruturaCubo[0].animate([
	            // keyframes
	            { transform: "rotateY(" + (nCont2 - 90).toString() +"deg)" },
	            { transform: "rotateY(" + (nCont2).toString() +"deg)" }
	        ], {
	            // timing options
	            duration: 1000,
	            iterations: 1
	        });	
		}			
	}, 2000)
}
