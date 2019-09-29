<script type="text/javascript">
	//window.setTimeout("history.back(-2)", 5000); 
</script>
<head>
	<!-- <meta http-equiv="Refresh" CONTENT="5;URL=ClassesPHP.txt"> -->
	<!-- apos 5 segundos exibi o arquivo com todas as classes geradas -->
</head>
<?php
/*
	Programm: gerador_classes.php
	Objective: Generated all class for object orientation in PHP from archeve sql
	Autor: Hélio Barbosa

	GitHub: https://github.com/helhoso/PHPCodeGenerator.git
	linkedin: https://br.linkedin.com/in/helio-barbosa-32718082
	email: hflb01@gmail.com
	youtube: https://www.youtube.com/user/1908HELIO
*/
	echo ("</br>Gerando Classes PHP....</br>") ;
	echo ("Recebendo arquivo....</br>") ;
	$nome_temporario=$_FILES["Arquivo"]["tmp_name"];
	$nome_real=$_FILES["Arquivo"]["name"];
	copy($nome_temporario,"arq_sql/$nome_real");

	include_once("gerador_gerar_classes.php")  ;
	$NewGerar = New Gerar() ;
	$NewGerar->setArquivoSQL($nome_temporario);
	$myClassGerated = $NewGerar->gerarObjPHP();
	echo ("<a href='". $myClassGerated . "'> Baixar arquivo com Classes </a>") ;
?>
</body>
