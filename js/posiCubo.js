//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var Navegacao = document.getElementsByTagName('header');
var NavOpc = document.getElementsByTagName('li');
var ListAmigos = document.getElementsByClassName('lista_amigos');
//Numerico
var antOpc = 0;
var nAntPosic = 0;
//Array
var posic = [0, 90, 180, 270, 360];
//String
var Parametro = document.getElementsByName('Amigos');
//Booleano
var lAbriu = false;

//===================================Escopo=========================================
if(Parametro.length > 0){
    NavOpc[0].className = 'nav-item';
    NavOpc[2].className = 'nav-item actived';
    antOpc = 2;
    nAntPosic = 180;
}

//===========================Função====================================
function rotaciona(opc) {
    
    if (antOpc === opc) {
        return;
    }

    //Anima a rotação
    EstruturaCubo[0].animate([
        // keyframes
        { transform: "rotateY(" + nAntPosic.toString() + "deg)" },
        { transform: "rotateY(" + (posic[opc]).toString() + "deg)" }
    ], {
        // timing options
        duration: 1000,
        iterations: 1
    });

    //Fixa na Posição Atual
    EstruturaCubo[0].style.transform = "rotateY(" + (posic[opc]).toString() + "deg)";
    EstruturaCubo[0].style.webkitTransform = "rotateY(" + (posic[opc]).toString() + "deg)";

    //Seleciona NavBar Escolhida
    NavOpc[antOpc].className = 'nav-item';
    NavOpc[opc].className = 'nav-item actived';

    //Recebe valores Anteriores para futuras Validações
    nAntPosic = posic[opc];
    antOpc = opc;
}


function lista_amigos(){

    if(lAbriu === false){
        lAbriu = true;
       ListAmigos[0].style.display = 'flex';     
    }else{
        ListAmigos[0].style.animation = 'sumir 1s'; 
        var X = setTimeout(()=>{
            lAbriu = false;
            ListAmigos[0].style.display = 'none'; 
            ListAmigos[0].style.animation = 'aparecer 1s'; 
            clearTimeout(X);
        }, 1000)
    }

}



