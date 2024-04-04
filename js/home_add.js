//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var Navegacao = document.getElementsByTagName('header');
var Navegacao = document.getElementsByTagName('header');
var Telas = [
		document.getElementById('Novidades'),
		document.getElementById('Amigos'),
		document.getElementById('AddAmigos')
];

//====================================Escopos===================================
//Retira Animações
Navegacao[0].style.animation = 'none';
for(nCont = 0; nCont <= Telas.length -1; nCont++){
	Telas[nCont].style.animation = 'none';
	Telas[nCont].style.webkitAnimation = 'none';
	Telas[nCont].style.display = 'block'
}

//Posiciona o Cubo
EstruturaCubo[0].style.transform = "rotateY(180deg)";
Navegacao[0].className = 'd-block w-100 bg-light my-1 p-1';//Ativa a Navegação