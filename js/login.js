//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var Cena = document.getElementsByClassName('cena');
var Corpo = document.getElementsByTagName('main');
var EstruturaCubo = document.getElementsByClassName('cubo');
var formulario = document.getElementsByClassName('formulario');
var imagem = document.getElementsByClassName('balao');
//Numero
var nCont = 0;
//Arrays
var rotate = [0, 90, 180, -90, 90, -90]

//==================================Escopo============================================
Cena[0].style.animation = "surgi 2s";
Cena[0].className = "cena d-block";
EstruturaCubo[0].style.animation = "rotacionar 2s"
Cena[0].style.transform = " translateY(0px)";

/*
if(window.innerWidth <= 575.98){
	var x = setInterval(function(){

		if(nCont === 0){
			animaTela()
		}

		if(nCont === 1){
			clearInterval(x);
			expandeTela(220);
		}

		nCont++;
	},2000);
}
else{
	var x = setInterval(function(){

		if(nCont === 0){
			animaTela()
		}

		if(nCont === 1){
			clearInterval(x);
			aumentaCub();
		}

		nCont++;
	},2000);
}

//===================================Funções==========================================
function expandeTela(){
	Corpo[0].className = "d-block justify-content-center align-items-center h-100";

	Cubo[0].style.width = (window.innerWidth).toString() + 'px';
	Cubo[0].style.height = (window.innerHeight).toString() + 'px';
	formulario[0].className = "form-group text-center d-block formulario";
	formulario[1].className = "form-group text-center d-block formulario";
}

function aumentaCub(){
	Cena[0].style.width = "500px" ;
	Cena[0].style.height = "500px";

	formulario[0].className = "form-group text-center d-block formulario";
	formulario[1].className = "form-group text-center d-block formulario";

	for(nCont = 0; nCont <= Cubo.length -1; nCont++){
        Cubo[nCont].style.transform = "rotateY("+ rotate[nCont] + "deg) translateZ(250px)"; 
	}
}


function animaTela(){
	imagem[0].style.animation = "some 1s";

	var Z = setTimeout(function(){
		imagem[0].style.display = "none";
		clearTimeout(Z);	
	}, 1000)
}
*/