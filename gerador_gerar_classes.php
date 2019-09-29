<?php
	// Todas as classes serão criadas em um unico arquivo
	// separe-as posteriormente
	// https://github.com/
	class Gerar{
		private $arquivoSQL ;
		private $arquivoOBJ ;
		public  $inicio     ;
		public  $final      ;
		public  $arrayProp  ;

      function __construct() { 
		$this->arquivoSQL = null; 
		$this->arquivoOBJ = null; 
      } 

      function __destruct() { 
		$this->arquivoSQL = null; 
		$this->arquivoOBJ = null; 
      }

      private function getArquivoSQL(){
        return $this->codigo ;
      }
      public function setArquivoSQL($_arquivo){
        $this->arquivoSQL = $_arquivo ;
      }

      public function gerarObjPHP(){
		if(file_exists("ClassesPHP.txt"))
		{
			unlink("ClassesPHP.txt") ;
		}
		$textClass = "<?php" . chr(10) ;
		$fp        = fopen("ClassesPHP.txt","a");
      	$inicio    = false   ;
      	$final     = true    ;
      	$class_name= ""      ;
      	$arrayProp = array() ;    ;
		if ($fh = fopen($this->arquivoSQL, 'r')) {
		    while (!feof($fh)) {
		        $line = fgets($fh);
		        if(strpos($line, "TABLE IF NOT EXISTS")!=0 && $final)
		        {
		        	$inicio = true  ;
		        	$final  = false ; 
		        	echo ("</br></br>");
		        }
		        if(strpos($line, " ENGINE=")!=0 && !$final)
		        {
		        	$inicio = false ;
		        	$final  = true  ;
		        	echo ("</br></br>");
		        }
		        if($inicio && !$final)
		        {
		        	// Set Get dos atributos/propriedades
		        	if( strpos($line,"PRIMARY KEY")!=0){
		        		$textClass  = $textClass . chr(10) ;
		        		for($x=0 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
			        		$textClass  = $textClass . 
			        		"       function set" . $arrayProp[$x] . 
			        		"(". "$" . "_" . $arrayProp[$x] . ")" 
			        		.chr(10). "       {" 
			        		.chr(10). "           " . "$" ."this->" .$arrayProp[$x]. " = $" ."_" .$arrayProp[$x]. " ;" . chr(10) . "       }" . chr(10) ;
			        	}
				        /* Classes de Data Manipulation - Acesso ao SGBD */

				        // Inserir registro novo 209
				        $textClass  = $textClass . "       function inserir". $class_name . "()".chr(10) . "       {" .chr(10) ;

				        $select = "$" ."mySelect = 'select ";
		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$select = $select .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$select = $select .$arrayProp[ $y ] . " where " ;
		        		$select = $select .$arrayProp[0] . " = ' . $" . "this->" .$arrayProp[0] . " ;" ;

				        $textClass  = $textClass . "           include('myCon.php') // transformar em uma classe;". chr(10)  ;
				        $textClass  = $textClass . "           ". $select .chr(10)  ;
				        $textClass  = $textClass . "          $". "ret = mysqli_query($" ."myCon , $" . "mySelect) ;" .chr(10)  ;
				        $textClass  = $textClass . "          $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "          if($". "numRows>0)"  .chr(10). "          {" .chr(10) ;
				        $textClass  = $textClass ."              // Ja cadastrado" .chr(10) ;
				        $textClass  = $textClass ."              mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."              return -1 ; // ja cadastrado ".chr(10) ;
				        $textClass  = $textClass ."          }else{" .chr(10) ;
				        $textClass  = $textClass ."              // Incluir " .chr(10) ;

				        $insert = "$" ."myInsert = 'insert into " . $class_name ." (";
		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$insert = $insert .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$insert = $insert .$arrayProp[ $y ] . ") values (" ;

		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$insert = $insert ."$". "this->" . $arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$insert = $insert ."$" ."this->". $arrayProp[ $y ] . ")' ; " ;
				        $textClass  = $textClass ."              $insert" .chr(10) ;
				        $textClass  = $textClass ."              $" . "ret = mysqli_query($" . "myCon , $". "myInsert) ;" .chr(10) ;
				        $textClass  = $textClass ."              $" . "new_rec = mysqli_insert_id($" . "myCon) ;" .chr(10) ;
				        $textClass  = $textClass ."              return $" . "new_rec ; // se for 0 deu erro na inclusao" .chr(10) ;

				        $textClass  = $textClass ."          }" .chr(10) ;
				        $textClass  = $textClass . "       }" .chr(10) ;

				        // Numero de linhas da tabela 201

				        // Recuperar // set em todos atributos da classe 379

				        // Buscar - recebe parametros (filtro) e retornar linhas da tabela (vetor) 263

				        // ExecuteSelect - 429

				        // Excluir - 469

				        // Alterar - 501 

				        $textClass  = $textClass . "   }" .chr(10) .chr(10) ;
				        // Criar Classe Conexao


				        $inicio     = false   ;
				        $final      = true    ;
				        $class_name = ""      ;
				        $class_pro  = ""      ;
				        $arrayProp  = array() ;				        
		        	}else{
		        		// declaração da Classe
			        	$pi         = strpos($line, "`")       ;
			        	$restoLinha = substr($line, $pi+1)       ;
			        	$pf         = strpos($restoLinha, "`") ;
			        	if($class_name== "")
			        	{
				        	$class_name = substr($restoLinha,0,$pf)  ;
				        	$class_name = strtoupper( substr($class_name,0,1) ) . substr($class_name,1) ;
				        	$textClass  = $textClass . "   class $class_name" . "{" .chr(10) ;
			        	}else{
				        	$class_pro = substr($restoLinha,0,$pf)  ;
				        	$class_pro = strtoupper( substr($class_pro,0,1) ) . substr($class_pro,1) ;
			        		$textClass  = $textClass . "       private $class_pro ;" .chr(10);
			        		$arrayProp[ sizeof($arrayProp) ] = $class_pro ; 
			        	}   
			        	// echo ("$class_name </br>");
			        }
			        echo ("$textClass </br></br>") ;
		        }
		        // echo ("$line </br>");
		    }
		    $textClass  = $textClass . "?>" ;
		    fclose($fh);
		    fwrite( $fp,$textClass.chr(10).chr(13) ) ;
			fclose( $fp ) ;
		}         
      }
  }
/*
			        		$textClass  = $textClass . 
			        		"       function set" . $arrayProp[$x] . 
			        		"($_" . $arrayProp[$x] . ")" 
			        		.chr(10). "{" 
			        		.chr(10). "           $this->" .$arrayProp[$x]. " = $_" 
			        		.$arrayProp[$x]. chr(10);
*/
?>
