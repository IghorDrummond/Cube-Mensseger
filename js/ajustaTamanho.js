//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var EstruturaCubo = document.getElementsByClassName('cubo');
var Cena = document.getElementsByClassName('cena');
var imagem = document.getElementsByClassName('balao');
var formulario = document.getElementsByClassName('formulario');
//Numerico
var tamanho = 0;
var nCont = 0;
//Array
var rotacao = [0, 90, 180, -90, 90, -90];

//==================================Escopo==========================
//tamanho para telas acima de 650
tamanho = 500;
//define o tamanho do cubo caso a tela é menor que 650
if (window.innerWidth < 650) {
	tamanho = window.innerWidth - 80;
}
//Configura o cubo para ficar fixo na tela
Cena[0].className = "cena d-block";
Cena[0].style.transform = " translateY(0px)";
Cena[0].style.webkitTransform = " translateY(0px)";
Cena[0].style.width = tamanho.toString() + "px";
Cena[0].style.height = tamanho.toString() + "px";
//Desliga o Balão
imagem[0].style.display = "none";
//Liga Formulario
formulario[0].className = "text-center d-block formulario";
formulario[1].className = "text-center d-block formulario";
//Pega o tamanho do cubo e divide por 2 para colocar no tamanho correto	
for (nCont = 0; nCont <= Cubo.length - 1; nCont++) {
	Cubo[nCont].style.transform = "rotateY(" + rotacao[nCont] + "deg)translateZ(" + (tamanho / 2) + "px)";
	Cubo[nCont].style.webkitTransform = "rotateY(" + rotacao[nCont] + "deg)translateZ(" + (tamanho / 2) + "px)";
}

