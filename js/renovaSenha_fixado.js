//Declaração de Variaveis Globais
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var CorpoForm = document.getElementsByClassName('formularios');
var CampoEmail = document.getElementsByClassName('codigo');
//=====================Escopo============================
EstruturaCubo[0].style.transform = "rotateX(90deg)";
CorpoForm[0].className = "d-none formularios";
//Desliga o Campo Email
CampoEmail[0].className = "d-none codigo";
//Ativa os Itens Necessario para Construção da Página
CampoEmail[1].className = "d-block codigo";

