<?php
	$nome           = $_GET['nameId'];
	$senha          = $_GET['senhaId'];
	include("myclasses.php") ;
	$NewUsuario = New Usuario() ;
	//$NewUsuario->setCodigo_empresa($codigo_empresa);
	$NewUsuario->setNome($nome);
	$NewUsuario->setSenha($senha);
	$NewUsuario->setCodigo_empresa(1);
	echo $NewUsuario->getNome() . "</br>" . $NewUsuario->getSenha() . "</br>" . $NewUsuario->getCodigo_empresa() . "</br>";
	$NewCod = $NewUsuario->inserirUsuario() ;
	echo $NewCod . "</br>";
?>