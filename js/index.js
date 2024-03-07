//Declaração de Variaveis Globais
//Elementos
var Texto = document.getElementsByTagName('p');
var Corpo = document.getElementsByTagName('main');
//Numerico
var nCont = 0;
//Função Anônima
var y = setInterval(function () {

	if (nCont === 3) {
		Texto[0].innerText = '.';
		nCont = 0;
	}
	else {
		Texto[0].innerText += '.';
	}
	nCont++;
}, 1000);

//=====================================Funções================================
function Entrar(){
	//Limpa o Intervalo
	clearInterval(y);
	//Desaparece as Informação
	Corpo[0].style.animation = "desaparecer 1s";

	var x = setTimeout(function(){
		Corpo[0].style.display = 'None';
		clearTimeout(x);
		window.location.href = "login.php";
	}, 1000)
}


