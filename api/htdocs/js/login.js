//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var Cena = document.getElementsByClassName('cena');
var Corpo = document.getElementsByTagName('main');
var EstruturaCubo = document.getElementsByClassName('cubo');
var formulario = document.getElementsByClassName('formulario');
var imagem = document.getElementsByClassName('balao');
var tela = document.getElementById('Tela');
var rotacao = [0, 90, -90, 90, 180, -90];//front, back, right, left, top, bottom
//Numero
var nCont = 0;
//Booleano
var lAjusta = false;

//==================================Escopo============================================
Cena[0].style.animation = "surgi 2s";
Cena[0].style.webkitAnimation = "surgi 2s";
Cena[0].className = "cena d-block";
EstruturaCubo[0].style.animation = "rotacionar 2s";
EstruturaCubo[0].style.webkitAnimation = "rotacionar 2s";
Cena[0].style.transform = " translateY(0px)";

if(window.innerWidth <= 575.98){
	Tamanho = 100;
}else if(window.innerWidth >= 576 && window.innerWidth <= 767.98){
	Tamanho = 150;
}
else{
	Tamanho = 200;
}

var x = setInterval(function(){

	if(nCont === 0){
		desligaBalao();
	}
	if(nCont === 1){
		//expande(nLimite, Tamanho);
		expande(Tamanho);
	}
	if(nCont === 2){
		clearInterval(x);
	}	
	nCont++;
},1000);
//===================================Eventos==========================================
window.addEventListener("scroll", function() {
    // Função a ser executada quando ocorrer o evento de scroll
    alert("Rolou a página!");
});
//===================================Funções==========================================
/*
================================================================
Função: desligaBalao()
Descrição: responsavel por desligar o balão branco para ativar logo em seguida, o formulario
Data: 9/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function desligaBalao(){
	imagem[0].style.animation = "some 1s";
	imagem[0].style.webkitAnimation = "some 1s";

	var Z = setTimeout(function(){
		imagem[0].style.display = "none";
		clearTimeout(Z);
	}, 1000);
}

function expande(Limite){
	tamanho = 500;

	if(window.innerWidth < 650){
		tamanho = window.innerWidth - 80;
	}
	nCont = Limite;

	var y = setInterval(() => {
		if(nCont === tamanho){
			formulario[0].className = "text-center d-block formulario";
			formulario[1].className = "text-center d-block formulario";
			lAjusta = true;
			clearInterval(y);
		}

		Cena[0].style.width = nCont.toString() + "px";
		Cena[0].style.height = nCont.toString() + "px";

		for(nCont2 = 0; nCont2 <= Cubo.length -1; nCont2 ++){
			Cubo[nCont2].style.transform = (nCont2 == 2 || nCont2 == 3 ? "rotateX(" : "rotateY(") + rotacao[nCont2] +"deg)translateZ(" + (nCont / 2) + "px)";
			Cubo[nCont2].style.webkitTransform = (nCont2 == 2 || nCont2 == 3 ? "rotateX(" : "rotateY(") + rotacao[nCont2] +"deg)translateZ(" + (nCont / 2) + "px)";		
		}
		nCont++;	
	}, 0.5);	
}
