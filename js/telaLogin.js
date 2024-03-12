//Declaração de Variaveis Globais
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var CorpoForm = document.getElementsByClassName('formularios');
//Numerico
var nCont = -90;
//===================================Escopo========================================	

var Y = setInterval(() => {
	if (nCont === -1) {
		clearInterval(Y);
		//Redireciona para a página de Login
		window.location.href = "login.php";
	} else if (nCont === -70) {
		CorpoForm[0].style.animation = "none";
		CorpoForm[0].style.webkitAnimation = "none";
		CorpoForm[0].style.display = "block";
	}

	nCont++;
	EstruturaCubo[0].style.transform = "rotateY(" + nCont.toString() + "deg)";
	EstruturaCubo[0].style.webkitTransform = "rotateY(" + nCont.toString() + "deg)";
}, 15);