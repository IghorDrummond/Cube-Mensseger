//Elementos
var audioAmigo = new Audio('audio/Amigos.mp3');
var audioMensagem = new Audio('audio/mensagem.mp3');
var Pedidos = document.getElementsByClassName('pedidos_amizades');
var Itens = document.getElementsByClassName('Amigos-lista')
var Mensagens = document.getElementsByClassName('Mensagens');
var preTag = document.getElementsByTagName('pre');
var NavMsg = document.getElementsByClassName('notificacao_msg');
var itensAmigo = document.getElementsByClassName('amigo_lista_item');
//Arrays
var Posic  = [0,0,0,0,0];
var nAntMsg = Array.from({ length: Mensagens.length }, () => [0, false]);
//Numerico
var nCont = 0;
var nAnt = parseInt(Pedidos[0].innerText);
/*
	Lista de Pedidos
	Notas de Atts
	Conversa
	Lista de Adds 
	Lista de Amigos
*/
audioAmigo.volume = 0.5;	
var W = setInterval(() => {
    $("#Amigos").load("script/atualizaDados.php?opc=1", function() {
        // Restaura a posição do scroll y após a atualização
        if((preTag.length -1 ) > 3){
        	preTag[4].scrollTop = Posic[4];
        }

        nAntMsg.forEach(function(valor, indice){
        	if(valor[1]){
        		itensAmigo[indice].classList.add('nova_mensagem');
        	}
        });
    });

    $('#pedidos_amizades').load('script/atualizaDados.php?opc=2', function() {
        // Restaura a posição do scroll y após a atualização
        preTag[0].scrollTop = Posic[0];
    });

    $('#pedidos_amigos').load("script/atualizaDados.php?opc=3");

    //Caso houver uma nova adição de amigo, ele atualiza o tamanho do array de mensagens não lida
    if(Mensagens.length > nAntMsg.length){
    	var nTam = (nAntMsg.length -1) +1;	
    	nAntMsg[nTam] = [];
    	nAntMsg[nTam][0] = 0;
    	nAntMsg[nTam][1] = false;
    }

    //Valida se há nova mensagem, caso houver, emite um som ao usuário
    for(nCont = 0; nCont <= Mensagens.length -1; nCont++){
    	aux = parseInt((Mensagens[nCont].innerText).substring(0,(Mensagens[nCont].innerText).indexOf(' ')));

    	//Caso a mensagem for nova, ele atualiza soltando um som sonoro
    	if(nAntMsg[nCont][0] < aux){
    		audioMensagem.play();
    		nAntMsg[nCont][0] = aux;
    		if(nAntMsg[nCont][1] === false){
    			ajustaQtdMensagens(true);
    			itensAmigo[nCont].classList.add("nova_mensagem");
    			nAntMsg[nCont][1] = true;
    		}
    	}else if(nAntMsg[nCont][0] > aux){
    		nAntMsg[nCont][0] = aux;//Caso houver uma alteração para baixo o valor, ele atualiza automaticamente
    		if(nAntMsg[nCont][1]){
    			ajustaQtdMensagens(false);
    			itensAmigo[nCont].classList.remove("nova_mensagem");
    			nAntMsg[nCont][1] = false;
    		}
    	}
    }

    //Atualiza os Dados em Tempo Real para ver se há pedidos de Amizades enviado!
    if (parseInt(Pedidos[0].innerText) > nAnt) {
        audioAmigo.play();
        nAnt = parseInt(Pedidos[0].innerText);
    } else if (parseInt(Pedidos[0].innerText) < nAnt) {
        nAnt = parseInt(Pedidos[0].innerText);
    }
}, 1500);

//===============================Funções===============================================
//Adicionar a Lista de Amigos
$("#buscarAmg").click(function(){
	var valorDoInput = $("#nomeAmigo").val();

	$("#lista_adds").load("script/buscaAmigo.php?Nome=" + valorDoInput);
});

function adicionar(Email){
	$("#avisos").load("script/adicionarAmigo.php?Email=" + Email);
}

function posicTag(cont){
	Posic[cont] = preTag[cont].scrollTop;
}

function ajustaQtdMensagens(valor){
	var Soma = parseInt(NavMsg[0].innerText);
	valor ? Soma++: Soma--;
	NavMsg[0].innerText = Soma.toString();
	NavMsg[1].innerText = Soma.toString();
}
