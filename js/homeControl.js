//Adicionar a Lista de Amigos
$("#buscarAmg").click(function(){
	var valorDoInput = $("#nomeAmigo").val();

	$("#lista_adds").load("script/buscaAmigo.php?Nome=" + valorDoInput);
});

function adicionar(Nome){
	$("#avisos").load("script/adicionarAmigo.php?Nome=" + Nome);
}