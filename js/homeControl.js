var audio = new Audio('audio/Amigos.mp3');
var Pedidos = document.getElementsByClassName('pedidos_amizades');
var nAnt = parseInt(Pedidos[0].innerText);

audio.volume = 0.5;	

var W = setInterval(()=>{
	$("#Amigos").load("script/atualizaDados.php?opc=1");
	$("#pedidos_amizades").load("script/atualizaDados.php?opc=2");	
	$('#pedidos_amigos').load("script/atualizaDados.php?opc=3");

	//Atualiza os Dados em Tempo Real para ver se há pedidos de Amizades enviado!
	if(parseInt(Pedidos[0].innerText) > nAnt){
		audio.volume = 0.5;	
		audio.play();
		nAnt = parseInt(Pedidos[0].innerText);
	}else if(parseInt(Pedidos[0].innerText) < nAnt){
		nAnt = parseInt(Pedidos[0].innerText);
	}
}, 1500);

//Adicionar a Lista de Amigos
$("#buscarAmg").click(function(){
	var valorDoInput = $("#nomeAmigo").val();

	$("#lista_adds").load("script/buscaAmigo.php?Nome=" + valorDoInput);
});

function adicionar(Email){
	$("#avisos").load("script/adicionarAmigo.php?Email=" + Email);
}

