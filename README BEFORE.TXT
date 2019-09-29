
	Programm: gerador_classes.php
	Objective: Generat all class for object orientation in PHP from archeve sql
	Autor: Hélio Barbosa
	Youtub channel:
	https://www.youtube.com/channel/UCOqRfHNtUZu8zMImLrU9YeQ?view_as=subscriber
	
	IMPORTANTE
    O aquivo de origem tem que ser obrigatoriamente um .sql gerado por MySQL
    contendo as tags:
    "TABLE IF NOT EXISTS" para pegar o nome da tabela
     " ENGINE=" para saber o final da tabela
     "PRIMARY KEY" para entra no loop de leitura das colunas da tabela


	Todas as classes serão criadas em um unico arquivo
	aconselho a serapa-las para facilitar o include posteriormente

	Apos o arquivo ser gerado, altere a extensao para .PHP e separe as classes
	Ex.: "class Empresa" => "Empresa.php"


	GitHub: https://github.com/helhoso/PHPCodeGenerator.git
	linkedin: https://br.linkedin.com/in/helio-barbosa-32718082
	email: hflb01@gmail.com
	youtube: https://www.youtube.com/user/1908HELIO

	Utilizando o servidor Xampp
	Crie uma pasta com qualquer nome (GeradorClassesPHP) dentro da pasta htdocs
	no seu browser (chrome) digite o endereco
	http://localhost/GeradorClassesPHP/gerador_classes.php



