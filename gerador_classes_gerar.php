<script>
	//window.setTimeout("history.back(-2)", 5000); 
</script> 
<?php
	echo ("</br>Recebendo arquivo....") ;
	$nome_temporario=$_FILES["Arquivo"]["tmp_name"];
	$nome_real=$_FILES["Arquivo"]["name"];
	copy($nome_temporario,"arq_sql/$nome_real");

	echo ("</br></br>Gerando Classes PHP....") ;
	include_once("gerador_gerar_classes.php")  ;
	$NewGerar = New Gerar() ;
	$NewGerar->setArquivoSQL($nome_temporario);
	$NewGerar->gerarObjPHP();
	echo ("</br></br>Voltando a pagina inicial....") ;
?>
