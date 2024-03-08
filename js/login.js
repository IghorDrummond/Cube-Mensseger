//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var Cena = document.getElementsByClassName('cena');
var Corpo = document.getElementsByTagName('main');
var EstruturaCubo = document.getElementsByClassName('cubo');
var formulario = document.getElementsByClassName('formulario');
var imagem = document.getElementsByClassName('balao');
var rotacao = [0, 90, 180, -90, 90, -90];
//Numero
var nCont = 0;
//Arrays


//==================================Escopo============================================
Cena[0].style.animation = "surgi 2s";
Cena[0].className = "cena d-block";
EstruturaCubo[0].style.animation = "rotacionar 2s"
Cena[0].style.transform = " translateY(0px)";

if(window.innerWidth <= 1199.99){

	var x = setInterval(function(){

		if(nCont === 0){
			desligaBalao();
		}
		if(nCont === 1){
			expandeTela()
		}
		if(nCont === 2){
			clearInterval(x);
		}
		nCont++;
	},2000);
}

//===================================Funções==========================================
function desligaBalao(){
	//imagem[0].style.animation = "some 1s";

	var Z = setTimeout(function(){
		//imagem[0].style.display = "none";
		clearTimeout(Z);
	}, 1000);
}

function expandeTela(){

	tamanho = (window.innerWidth - 100);

	Cena[0].style.width = tamanho.toString() + 'px';
	Cena[0].style.height = (window.innerHeight - 250) + 'px';

	for(nCont = 0; nCont <= Cubo.length -1; nCont++){
		Cubo[nCont].style.transform = "rotateY("+ rotacao[nCont].toString() +"deg) translateZ("+ (tamanho / 2).toString() +"px)";
	}
}
