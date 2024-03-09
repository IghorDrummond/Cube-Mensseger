//Declaração de Variaveis Globais
//Elementos
var Cubo = document.getElementsByClassName('cubo-face');
var EstruturaCubo = document.getElementsByClassName('cubo');
var Cena = document.getElementsByClassName('cena');
var imagem = document.getElementsByClassName('balao');
var formulario = document.getElementsByClassName('formulario');
var tela = document.getElementById('Tela');
//Numerico
var tamanho = 0;
var nCont = 0;
//Array
var rotacao = [0, 90, 180, -90, 90, -90];

alert('Foi')
EstruturaCubo[0].style.animation = "errado 4s infinity !important";
EstruturaCubo[0].style.webkitAnimation = "errado 4s infinity !important";

function Fechar(){
	Tela.style.animation = "sumir 1s"
	var P = setTimeout(() =>{
		Tela.style.display = 'none';
		clearTimeout(P);
	}, 1000);
}