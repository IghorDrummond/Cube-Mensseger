//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var barra = document.getElementsByClassName('progress-bar');
var porcentagem = document.getElementById('Loading');
var Carregamento = document.getElementById('Carregamento');
var Navegacao = document.getElementsByTagName('header');
var Telas = [
		document.getElementById('Novidades')
];

//===================================Escopo=========================================
carregamento();//Ativa a tela de carregamento

//===================================Funções=========================================
function carregamento(){
	var nCont = 20;
	var nCont2 = 0;

	Telas[0].style.display = 'block';

	var Z = setInterval(() =>{
		nCont += 20;
		nCont2 += 90;

		//Fixa na posição que ja foi rotacionada
		EstruturaCubo[0].style.transform = "rotateY(" + (nCont2).toString() +"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateY(" + (nCont2).toString() +"deg)";

		if(nCont > 100){
			clearInterval(Z);//Limpa o Intervalo
			Carregamento.className = 'd-none';//Desativa barra de progresso
			Navegacao[0].className = 'd-block w-100 bg-light my-1 p-1';//Ativa a Navegação
			//Posiciona o Cubo na posição Inicial (0)
			EstruturaCubo[0].style.transform = "rotateY(0deg)";
			EstruturaCubo[0].style.webkitTransform = "rotateY(0deg)";		
		}else if(nCont2 <=  360){
			//Ajusta a porcetagem da barra de progresso
			barra[0].style.width = nCont.toString() + '%';
			porcentagem.textContent = nCont.toString() + '%';

			//Anima a rotação
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
