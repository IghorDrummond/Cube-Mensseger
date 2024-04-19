//Declaração de Variaveis
//Elementos
var EstruturaCubo = document.getElementsByClassName('cubo');
var Navegacao = document.getElementsByTagName('header');
var NavOpc = document.getElementsByTagName('li');
var ListAmigos = document.getElementsByClassName('lista_amigos');
var CampoMensagem = document.getElementsByClassName('Mensagem');
var BotaoEnviar = document.getElementsByClassName('Enviar');
//Numerico
var antOpc = 0;
var nAntPosic = 0;
var Chat = 0;
var nAntMsg = 0;
//Array
var posic = [0, 90, 180, 270, 360];
//String
var Parametro = document.getElementsByName('Amigos');
var idEnv = '';
//Booleano
var lAbriu = false;
//Funções Anonimas
var atualizaParametro = function(id){
    return function(){
        tarefa('Enviar ' + id);
    }
}

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

function tarefa(val){
    var opc  = val.indexOf(' ') >= 0 ? val.substring(0, val.indexOf(' ')) : val;
    var id = val.substring(val.indexOf(' ') +1, val.length);
    var Mensagem = '';
    var Qtd = document.getElementsByTagName('blockquote');

    if(opc === 'Conversar'){
        idEnv = id;
        AtivaChat(id);//Ativa o Chat
        var J = setTimeout(()=>{
            //Retira o Display
            Navegacao[0].className = "d-none w-100 bg-light my-1";
            EstruturaCubo[0].style.transform = "rotateY(0deg) rotateX(90deg)";
            EstruturaCubo[0].style.webkitTransform = "rotateY(0deg) rotateX(90deg)";   
            clearTimeout(J);        
        }, 1000);
        //Anima a Rotação para a face da Conversa
        EstruturaCubo[0].animate([
            // keyframes
            { transform: "rotateY( "+ nAntPosic.toString() + "deg) rotateX(0deg)" },
            { transform: "rotateY(0deg) rotateX(90deg)" }
        ], {
            // timing options
            duration: 1000,
            iterations: 1
        });      
        //Delisga a Barra de Navegação
        Navegacao[0].style.animation = "sumir 1s";   
    }else if(opc === 'Sair'){
        clearInterval(Chat);  
        Navegacao[0].style.animation = "aparecer 1s";   
        Navegacao[0].className = "d-block w-100 bg-light my-1";        
        EstruturaCubo[0].animate([
            // keyframes
            { transform: "rotateY(0deg) rotateX(90deg)" },
            { transform: "rotateY( "+ nAntPosic.toString() + "deg) rotateX(0deg)" },            
        ], {
            // timing options
            duration: 1000,
            iterations: 1
        });    

        var J = setTimeout(()=>{
            EstruturaCubo[0].style.transform = "rotateY( "+ nAntPosic.toString() + "deg) rotateX(0deg)";
            EstruturaCubo[0].style.webkitTransform = "rotateY( "+ nAntPosic.toString() + "deg) rotateX(0deg)";  
            clearTimeout(J);        
        }, 1000);                
    }else if('Enviar'){
        //Forma os Espaços para ir completo para gravação de Mensagens
        Mensagem = trataMensagem("_", "'SaS'", CampoMensagem[0].value);  
        Mensagem = trataMensagem(" ", "_", Mensagem);         
        CampoMensagem[0].value = "";//Reseta o Campo de Mensagem
        $('#Conversar').load('script/mensagem.php?id=' + idEnv + '&Mensagem=' + Mensagem + '&msgqtd=' + (Qtd.length).toString());
    }
}

function AtivaChat(id){
    Chat = setInterval(() =>{
        $('#Conversar').load('script/mensagem.php?id=' + idEnv);
    }, 1000);
}

function trataMensagem(encontrar, substituir, Mensagem){
    var posic = 0;

    while(posic != -1){
        Mensagem = Mensagem.replace(encontrar, substituir);
        posic = Mensagem.indexOf(encontrar);
    }    

    return Mensagem;
}