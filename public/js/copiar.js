/*
 * A clicar no botão copiar o conteudo da <div> para a àrea de transferêcia
 */
var clipboard = new Clipboard('.btn'); 
clipboard.on('success', function(e){
	console.log(e); 
}); 
clipboard.on('error', function(e){
	console.log(e);  
});

