//Declaração de Variaveis Globais
//Elementos
var CorpoForm = document.getElementsByClassName('formularios');
var EstruturaCubo = document.getElementsByClassName('cubo');
//Numerico
var nCont = 0;

//==================================Escopo==========================================
desloca()//Chama Função Desloca
//==================================Funções=========================================
/*
================================================================
Função: desloca()
Descrição: Rotaciona o Cubo novamente para o formulario e Login
Data: 21/03/2024
Progamador(a): Ighor Drummond 
================================================================
*/
function desloca(){
	var nCont = 90;

	var Y = setInterval(() =>{
		if(nCont === 1){	
			clearInterval(Y);		
			window.location.href = "login.php";
		}else if(nCont === 40){
			CorpoForm[0].style.animation = "aparecer 1s";
			CorpoForm[0].style.webkitAnimation = "aparecer 1s";			
			CorpoForm[0].className = "d-block formularios w-100 m-auto";	
		}
		nCont--;
		EstruturaCubo[0].style.transform = "rotateX(" +  nCont.toString() +"deg) rotateY("+nCont.toString()+"deg)";
		EstruturaCubo[0].style.webkitTransform = "rotateX(" +  nCont.toString() +"deg) rotateY("+nCont.toString()+"deg)";		
	}, 15);
}