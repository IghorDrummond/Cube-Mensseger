
var W = setInterval(()=>{
	$("#Amigos").load("script/atualizaDados.php?opc=1");
	$("#pedidos_amizades").load("script/atualizaDados.php?opc=2");	
	$('#pedidos_amigos').load("script/atualizaDados.php?opc=3");
}, 1500);

//Adicionar a Lista de Amigos
$("#buscarAmg").click(function(){
	var valorDoInput = $("#nomeAmigo").val();

	$("#lista_adds").load("script/buscaAmigo.php?Nome=" + valorDoInput);
});

function adicionar(Email){
	$("#avisos").load("script/adicionarAmigo.php?Email=" + Email);
}


