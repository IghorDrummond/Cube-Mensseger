//Declaração de Variaveis Globais
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var CorpoForm = document.getElementsByClassName('formularios');
var CampoEmail = document.getElementsByClassName('codigo');
var Cabecalho = document.getElementsByTagName('header');
//=====================Escopo============================
EstruturaCubo[0].style.transform = "rotateX(90deg)";
CorpoForm[0].className = "d-none formulario";
//Desliga o Campo Email
CampoEmail[0].style.animation = "sumir 1s";
CampoEmail[0].style.webkitAnimation = "sumir 1s";

var Y = setTimeout(() =>{
	CampoEmail[0].className = "d-none codigo";
	CampoEmail[1].className = "d-block codigo";
	Cabecalho[0].style.display = 'block';
}, 1000);

