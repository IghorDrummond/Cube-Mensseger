//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var FacesCubo = document.getElementsByClassName('cubo-face');
var barra = document.getElementsByClassName('progress-bar');
var porcentagem = document.getElementById('Loading');
var Carregamento = document.getElementById('Carregamento');
var Navegacao = document.getElementsByTagName('header');
var Telas = [
		document.getElementById('Novidades'),
		document.getElementById('Amigos'),
		document.getElementById('AddAmigos'),
		document.getElementById('Configuracao')
];
var Classes = [
	'd-block',
	'text-center d-block',
	'w-100 h-100 d-flex justify-content-center align-items-center flex-column',
	'bg-white h-100 w-100 d-block'
];
//String
var Parametro = (window.location.search).substring(6, (window.location.search).length);

//===================================Escopo=========================================

//Ativa o Carregamento Automatico
Carregamento.className = "d-flex justify-content-center align-items-center m-auto flex-column";
carregamento();//Ativa a tela de carregamento

//===================================Funções=========================================
function carregamento(){
	var nCont = 20;
	var nCont2 = 0;
	var nCont3 = 0;

	Telas[nCont3].className = Classes[nCont3];
	nCont3++;

	var Z = setInterval(() =>{
		nCont += 20;
		nCont2 += 90;
		
		if(nCont3 <= 3){
			Telas[nCont3].className = Classes[nCont3];
			nCont3++;
		}		
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
	}, 1200);
}

function animaCubo(opc){

	switch(opc){
		case 1 :
			animacao = 'arcoirisFundo 2s alternate-reverse infinite';
			break;
		default:
			animacao = 'none';
			break;
	}
	Array.from(FacesCubo).forEach(function(Faces){
		Faces.style.animation = animacao;
		Faces.style.webkitAnimation = animacao;
	});
}

function tela_Amigos(){
	//Retira Animações
	for(nCont = 0; nCont <= Telas.length -1; nCont++){
		Telas[nCont].style.animation = 'none';
		Telas[nCont].style.webkitAnimation = 'none';
		Telas[nCont].style.display = 'block'
	}

	EstruturaCubo[0].style.transform = "rotateY(180deg)";
	Navegacao[0].className = 'd-block w-100 bg-light my-1 p-1';//Ativa a Navegação
}
