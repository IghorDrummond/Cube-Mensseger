var audio = new Audio('audio/Amigos.mp3');
var Pedidos = document.getElementsByClassName('pedidos_amizades');
var nAnt = parseInt(Pedidos[0].innerText);
var Posic  = [0,0,0,0];
var preTag = document.getElementsByTagName('pre');
var nCont = 0;
/*
	Lista de Pedidos
	Notas de Atts
	Lista de Adds 
	Lista de Amigos
*/

audio.volume = 0.5;	
var W = setInterval(() => {
    $("#Amigos").load("script/atualizaDados.php?opc=1", function() {
        // Restaura a posição do scroll y após a atualização
        preTag[3].scrollTop = Posic[3];

	    $(document).on('mouseenter', '#Amigos', function() {
	        // Código para animação hover no evento de mouseenter
	    });

	    $(document).on('mouseleave', '#Amigos', function() {
	        // Código para animação hover no evento de mouseleave
	    });
    });

    $('#pedidos_amizades').load('script/atualizaDados.php?opc=2', function() {
        // Restaura a posição do scroll y após a atualização
        preTag[0].scrollTop = Posic[0];
    });

    $('#pedidos_amigos').load("script/atualizaDados.php?opc=3");

    //Atualiza os Dados em Tempo Real para ver se há pedidos de Amizades enviado!
    if (parseInt(Pedidos[0].innerText) > nAnt) {
        audio.volume = 0.5;
        audio.play();
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