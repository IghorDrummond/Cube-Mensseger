//Elementos
var audioAmigo = new Audio('audio/Amigos.mp3');
var audioMensagem = new Audio('audio/mensagem.mp3');
var audioNovaMensagem = new Audio('audio/nova_mensagem.mp3');
var Pedidos = document.getElementsByClassName('pedidos_amizades');
var Itens = document.getElementsByClassName('Amigos-lista')
var Mensagens = document.getElementsByClassName('Mensagens');
var preTag = document.getElementsByTagName('pre');
var NavMsg = document.getElementsByClassName('notificacao_msg');
var itensAmigo = document.getElementsByClassName('amigo_lista_item');
var Conversa = document.getElementsByTagName('blockquote');
var Descer = document.getElementsByClassName('descer');
var Vistos = document.getElementById('Conversar').getElementsByTagName('img');
var Emails = document.getElementsByClassName('opcao_lista')[0].getElementsByTagName('li');
//Arrays
var Posic  = [0,0,0,0,0,0];
var nAntScroll = [0,0];
var nAntMsg = Array.from({ length: Mensagens.length }, () => [0, false, false, false, 'Email']);
//Numerico
var nCont = 0;
var nMsg = 0;
var nAnt = parseInt(Pedidos[0].innerText);
var Acao = -1;
var Execucao = 0;
//Objeto
var data = {
    // Definindo os dados a serem enviados
    Senha: '',
    ConfirmeSenha: ''
}
//Booleano
var lEnvio = false;
var lTrava = false;
/*
	Lista de Pedidos -0
	Notas de Atts -1
    Configuração -2
	Conversa -3
	Lista de Adds -4
	Lista de Amigos -5
*/

for(nCont = 0; nCont <= itensAmigo.length -1 ; nCont++){
    nAntMsg[nCont][4] = itensAmigo[nCont].id;//Adiciona um Id para cada campo
}

audioAmigo.volume = 0.5;
var W = setInterval(() => {
    $("#Amigos").load("script/atualizaDados.php?opc=1", function() {
        // Restaura a posição do scroll y após a atualização
        if((preTag.length -1 ) > 3){
        	preTag[5].scrollTop = Posic[5];
        }

        nAntMsg.forEach(function(valor, indice){
        	if(valor[1] && valor[2] === false){
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
        reconstroiIndice();             
    }
    //Destroi o indice do array após deletação
    Execucao > 0 ? destroiIndice(Acao) : '';
    //Valida se há nova mensagem, caso houver, emite um som ao usuário
    for(nCont = 0; nCont <= Mensagens.length -1; nCont++){
    	aux = (Mensagens[nCont].innerText).substring(0,(Mensagens[nCont].innerText).indexOf(' ')).trim();

        if(aux === 'ø'){
            continue;
        }

        //Converte o Valor String para Numerico
        aux = parseInt(aux);
    	//Caso a mensagem for nova, ele atualiza soltando um som sonoro apenas para chats não ativos
    	if(nAntMsg[nCont][0] < aux && nAntMsg[nCont][2] === false){
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


function tarefa(val){
    var opc  = val.indexOf(' ') >= 0 ? val.substring(0, val.indexOf(' ')) : val;
    var id = val.substring(val.indexOf(' ') +1, val.length);
    var Mensagem = '';
    var Qtd = null;//Guarda quantidade de elementos blockquote

    if(opc === 'Conversar'){
        Acao = parseInt(val.substring(val.indexOf('[') +1, val.indexOf(']')));
        id = val.substring(val.indexOf(' ') +1, val.indexOf('.csv') +4);
        idEnv = id;
        AtivaChat(id, Acao);//Ativa o Chat
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
    }else if(opc === 'Deletar'){
        if(confirm('Tem certeza de que deseja excluir este usuário?')){
            $('#Amigos').load('script/operacao.php?Email=' + id + '&opc=Deletar');
        }
    }else if(opc === 'Bloquear'){
        Acao = parseInt(val.substring(val.indexOf('[') +1, val.indexOf(']')));
        id = val.substring(val.indexOf(' ') +1, val.indexOf('.com')+4);

        if(confirm('Tem certeza de que deseja bloquear este usuário? Após o bloqueio, você não verá mais esta pessoa na lista de amigos e não receberá mais mensagens dela.')){
            $('#Amigos').load('script/operacao.php?Email=' + id + '&opc=Bloquear');
            Execucao = 1;
        }         
    }else if(opc === 'Silenciar'){
        Acao = parseInt(val.substring(val.indexOf('[') +1, val.indexOf(']')));
        id = val.substring(val.indexOf(' ') +1, val.indexOf('.com')+4);

        if(confirm('Tem certeza de que deseja silenciar este usuário? Ao fazê-lo, você não receberá mais notificações relacionadas a ele.')){
            $('#Amigos').load('script/operacao.php?Email=' + id + '&opc=Silenciar');
            nAntMsg[Acao][2] = true;//Ativa silenciamento para usuário
            //Formata as Mensagens para padrão
            if(nAntMsg[Acao][0] > 0){
                ajustaQtdMensagens(false);
                nAntMsg[Acao][0] = 0;
                nAntMsg[Acao][1] = false;
            }            
        }
    }else if(opc === 'Reativar'){
        Acao = parseInt(val.substring(val.indexOf('[') +1, val.indexOf(']')));
        id = val.substring(val.indexOf(' ') +1, val.indexOf('.com')+4);
        nAntMsg[Acao][2] = false;
        $('#Amigos').load('script/operacao.php?Email=' + id + '&opc=Reativar');   

    }else if(opc === 'Desbloquear'){
        if(confirm("Confirmar Desbloqueio de Usuário?")){
            $('#Amigos').load('script/operacao.php?Email=' + id + '&opc=Desbloquear'); 
        }
    }else if(opc === 'Nome'){
        if(confirm("Confirmar a Troca de Nome?")){
            var Nome = document.getElementsByName('Nome')[0].value;
            var Sobrenome = document.getElementsByName('Sobrenome')[0].value;
            $('#avisos').load('script/Configuracao.php?Nome=' + Nome .trim() + '&Sobrenome='+ Sobrenome.trim() +'&Opc=Nome'); 

            var O = setTimeout(() =>{
                clearTimeout(O);
                location.reload();
            }, 5000);
        }
    }else if(opc === 'Trocar'){
        //Confirmar a Troca de Senha
        if(confirm("Confirmar a troca da Senha? você será deslogado e direcionado para a tela de Login.")){
            data.Senha = encodeURIComponent(document.getElementsByName('Senha')[0].value);
            data.ConfirmeSenha = encodeURIComponent(document.getElementsByName('ConfirmeSenha')[0].value);
            $('#avisos').load('script/operacao.php?opc=Trocar&Senha=' + data.Senha + '&ConfirmeSenha=' + data.ConfirmeSenha);
            document.getElementsByName('Senha')[0].value = "";
            document.getElementsByName('ConfirmeSenha')[0].value = "";
        }
    }else if(opc === 'Sair'){
        Qtd = document.getElementsByTagName('blockquote');
        nAntMsg[Acao][2] = false;
        Acao = -1;
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
    }else if(opc === 'Enviar'){
        Qtd = document.getElementsByTagName('blockquote');
        //Forma os Espaços para ir completo para gravação de Mensagens
        Mensagem = trataMensagem("_", "'SaS'", CampoMensagem[0].value);  
        Mensagem = trataMensagem(" ", "_", Mensagem);         
        CampoMensagem[0].value = "";//Reseta o Campo de Mensagem
        $('#Conversar').load('script/mensagem.php?id=' + idEnv + '&Mensagem=' + Mensagem + '&msgqtd=' + (Qtd.length).toString());
        //Carrega mensagem enviada e posiciona nela automaticamente
        lEnvio = true;
    }
}

function AtivaChat(id, divPosic){
    nAntMsg[divPosic][2] = true;
    //Carrega o chat pela primeira vez para posicionar o scroll na ultima mensagem enviada.
    $('#Conversar').load('script/mensagem.php?id=' + idEnv, function() {
        preTag[3].scrollTop = preTag[3].scrollHeight;
    });

    Chat = setInterval(() =>{
        $('#Conversar').load('script/mensagem.php?id=' + idEnv, function() {
            //Valida se o usuário enviou uma mensagem
            if(!lEnvio){
                //Valida se o usuário está na ultima mensagem
                if(preTag[2].offsetHeight + preTag[3].scrollTop >= nAntScroll[1]){
                    Descer[0].style.display = 'none';
                    lTrava = false;
                    nMsg = 0;
                    //Valida se chegou uma nova mensagem para você do usuário
                    if(validaNovaMensagem()){                    
                        //Aqui também desativará o botão descer
                        preTag[3].scrollTop = preTag[3].scrollHeight;  //Caso houver nova mensagem, ele ajusta o scroll para ultima
                    }
                }else{
                    if(!lTrava){
                        Descer[0].style.webkitAnimation = 'aparecer 1s';
                        Descer[0].style.animation = 'aparecer 1s';
                        lTrava = true;
                    }

                    if(Conversa.length > nAntScroll[0]){
                        nMsg += Conversa.length - nAntScroll[0];
                        audioNovaMensagem.play();
                    }

                    Descer[0].style.display = 'inline';
                    Descer[1].innerText = nMsg.toString();
                }

            }else{
                preTag[3].scrollTop = preTag[3].scrollHeight;  
                lEnvio = false;
            } 

            nAntScroll[0] = Conversa.length; //Guarda Quantidade de mensagens enviadas     
            nAntScroll[1] = (preTag[3].scrollHeight);//Guarda a ultimo tamanho da caixa de mensagens
        });
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

function validaNovaMensagem(){
    if(Conversa.length > nAntScroll[0]){
        return true;
    }

    return false;
}

function desceChat(){
    preTag[3].scrollTop = preTag[3].scrollHeight;
    Descer[0].style.display = 'none';
    lTrava = false;
    nMsg = 0;
}

function Configuracao(val){
    if (val === 'Foto') {
        var formData = new FormData();
        formData.append('foto', $('#Arquivo')[0].files[0]);
        $.ajax({
            url: 'script/Configuracao.php?Opc='+val,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Aqui você pode lidar com a resposta do servidor
                $('#avisos').html(response);
                var K = setTimeout(()=>{
                    clearTimeout(K);
                    location.reload();
                },5000);
            }
        });
    }else if(val === 'Senhas'){

    }
}

function trataLink(Link){
    var posic = 0;

    while(posic != -1){
        Link = Link.replace(' ', '|');
        posic = Link.indexOf(' ');
    }    

    return Link;
}

/*
================================================================
Função: ValidaSenha()
Descrição: Analisa se o Usuário Inseriu os caracteres exigidos
Data: 26/03/2024
Progamador(a): Ighor Drummond
================================================================
*/
function ValidaSenha(){
    //Declaração de Variaveis
    //Elementos
    var Lista = document.getElementById('regras_senha').getElementsByTagName('li');
    var Input = document.getElementsByName('Senha');
    //String
    var Carac = "";
    //Array
    var Simbolo = [['ABCDEFGHIJKLMNOPQRSTUVWXYZ'], ['@#_-%¨&;?!$()*><:Ç~´^,.=\/{}`´|[]+""£'] ,['0123456789'] ];
    //Numerico
    var nCont = 0;
    var nCont2 = 0;

    //Recupera o valor Digitado no Campo Senha
    Carac = Input[0].value;

    //Verifica o Tamanho da Senha
    (Carac.length +1) >= 8 ? Lista[0].className = "text-success" : Lista[0].className = "text-warning";

    //Verifica os Caracteres existentes dentro da String
    for(nCont = 0; nCont <= Simbolo.length -1; nCont++){
        for(nCont2 = 0; nCont2 <= Simbolo[nCont][0].length -1; nCont2++){
            if( Carac.indexOf(Simbolo[nCont][0].charAt(nCont2)) >= 0 ){
                Lista[nCont +1].className = "text-success";
                break;
            }
            else{
                Lista[nCont +1].className = "text-warning";
            }
        }
    }
}

function destroiIndice(posic){
    //Formata as Mensagens para padrão
    if(nAntMsg[posic][0] > 0){
        nAntMsg[posic][0] = 0;
        nAntMsg[posic][1] = false;        
        ajustaQtdMensagens(false);
    }       

    delete nAntMsg[posic];//Deleta o Indice desejado 
    nAntMsg = nAntMsg.filter(Boolean);   
    Execucao = 0;    
}

function reconstroiIndice(){
    var nCont = 0;  
    var nTam = 0;

    //Verifica se há um elemento entre outros novo.
    for(nCont = 0; nCont <= nAntMsg.length -1; nCont++){
        if(nAntMsg[nCont][4] != itensAmigo[nCont].id){
            nAntMsg.splice(nCont, 0, retornaFormato(itensAmigo[nCont].id));
        }    
    }
    //Caso tiver um novo usuário, ele adiciona uma nova posição aqui
    if(nAntMsg.length < Mensagens.length){
        nTam = (nAntMsg.length -1) +1;  
        nAntMsg[nTam] = [];
        nAntMsg[nTam][0] = 0;//Quantidades de Mensagens
        nAntMsg[nTam][1] = false;//se há uma nova mensagem para somar mais uma
        nAntMsg[nTam][2] = false;//se o usuário está silenciado ou não
        nAntMsg[nTam][3] = false;//se o usuário for bloqueado, ele guarda o valor caso for desbloqueado na mesma sessão
        nAntMsg[nTam][4] = itensAmigo[(itensAmigo.length-1)].id;//recebe o Email do Usuário.       
    }    
}

function retornaFormato(Id){
    var Ret = [];
    Ret[0] = 0;//Quantidades de Mensagens
    Ret[1] = false;//se há uma nova mensagem para somar mais uma
    Ret[2] = false;//se o usuário está silenciado ou não
    Ret[3] = false;//se o usuário for bloqueado, ele guarda o valor caso for desbloqueado na mesma sessão
    Ret[4] = Id;//recebe o Email do Usuário.
    return Ret;     
}