//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var Cena = document.getElementsByClassName('cena');
var imagem = document.getElementsByClassName('balao');
var formulario = document.getElementsByClassName('formulario');
//Numerico
var tamanho = 0;
var nCont = 0;
//Array			
var rotacao = [0, 90, -90, 90, 180, -90];//front, back, right, left, top, bottom
//==================================Escopo==========================
adaptar();
//==================================Funções==========================
function adaptar(){
	//tamanho para telas acima de 650px
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
	//Verifica se existe Balão no arquivo Php	
	if(typeof imagem[0] === 'object' ){
		//Desliga o Balão
		imagem[0].style.display = "none";
	}
	//Verifica se existe Balão no arquivo Php	
	if(typeof formulario[0] === 'object'){
		formulario[0].className = "text-center d-block formulario";
		//Liga Formulario
		if(formulario.length > 1 ){
			formulario[1].className = "text-center d-block formulario";
		}
	}
	//Pega o tamanho do cubo e divide por 2 para colocar no tamanho correto	
	for(nCont2 = 0; nCont2 <= Cubo.length -1; nCont2 ++){
		Cubo[nCont2].style.transform = (nCont2 >= 2 && nCont2 <= 3 ? "rotateX(" : "rotateY(") + rotacao[nCont2] +"deg)translateZ(" + (tamanho / 2) + "px)";
		Cubo[nCont2].style.webkitTransform = (nCont2 >= 2 && nCont2 <= 3 ? "rotateX(" : "rotateY(") + rotacao[nCont2] +"deg)translateZ(" + (tamanho / 2) + "px)";		
	}
}

