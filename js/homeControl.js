
var W = setInterval(()=>{
	$("#pedidos_amizades").load("script/atualizaLista.php");
	$("#Amigos").load("script/atualizaAmigos.php");
	$('#pedidos_amigos').load("script/atualizaNav.php");
}, 1500);

//Adicionar a Lista de Amigos
$("#buscarAmg").click(function(){
	var valorDoInput = $("#nomeAmigo").val();

	$("#lista_adds").load("script/buscaAmigo.php?Nome=" + valorDoInput);
});

function adicionar(Email){
	$("#avisos").load("script/adicionarAmigo.php?Email=" + Email);
}


