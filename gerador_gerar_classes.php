<?php
/*
	Programm: gerador_classes.php
	Objective: Generated all class for object orientation in PHP from archeve sql
	Autor: Hélio Barbosa
	
	http://solucaofinal.com

	Todas as classes serão criadas em um unico arquivo
	separe-as posteriormente
	https://github.com/

	GitHub: https://github.com/helhoso/PHPCodeGenerator.git
	linkedin: https://br.linkedin.com/in/helio-barbosa-32718082
	email: hflb01@gmail.com
	youtube: https://www.youtube.com/user/1908HELIO

*/
	class Gerar{
		private $arquivoSQL ;
		private $arquivoOBJ ;
		public  $inicio     ;
		public  $final      ;
		public  $arrayProp  ;
		public  $FileGerated;
		public $comentarios;

      function __construct() { 
		$this->arquivoSQL  = null; 
		$this->arquivoOBJ  = null;
		$this->FileGerated = "FileClasse" . Date("ymd") . time("hms") .".TXT" ;
		$this->comentarios  = "/* ".chr(10)."Programm: gerador_classes.php" .chr(10). "Objective: Gerar classes em PHP oritenado a objeto a partir de um arquivo texto sql" .chr(10).
		"Autor: Hélio Barbosa" .chr(10). "Todas as classes serão criadas em um unico arquivo separe-as posteriormente" .chr(10). 
		"GitHub: https:/". "/github.com/helhoso/PHPCodeGenerator.git" .chr(10).
		"linkedin: https://br.linkedin.com/in/helio-barbosa-32718082" .chr(10).
		"email: hflb01@gmail.com" .chr(10). "youtube: https://www.youtube.com/user/1908HELIO" .chr(10). "*/" ;
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
		if(file_exists($this->FileGerated))
		{
			unlink($this->FileGerated) ;
		}

		$textClass = $this->comentarios . chr(10);
		$textClass = $textClass . "<?php" . chr(10) ;
		$fp        = fopen($this->FileGerated,"a");
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
		        }
		        if(strpos($line, " ENGINE=")!=0 && !$final)
		        {
		        	$inicio = false ;
		        	$final  = true  ;
		        }
		        if($inicio && !$final)
		        {
		        	// Set Get dos atributos/propriedades
		        	if( strpos($line,"PRIMARY KEY")!=0){
		        		// entra aqui apos finalizar as declaracoes dos atributos
		        		$textClass  = $textClass . "       private $" ."records_found ;" .chr(10) ;
		        		$textClass  = $textClass . "       private $" ."myCon ; // conexao com Banco de dados " .chr(10) .chr(10) ;

		        		// __construct()
		        		$textClass  = $textClass . "       function __construct() " . chr(10) . "       {" .chr(10) ;
		        		$textClass  = $textClass . "           $" . "this->codigo=null ; " .chr(10) ;
		        		$textClass  = $textClass . "           $" . "this->records_found=null ; " .chr(10) ;
		        		$textClass  = $textClass . "       }" .chr(10) ;

		        		// __destruct()
		        		$textClass  = $textClass . "       function __destruct() " . chr(10) . "       {" .chr(10) ;
		        		$textClass  = $textClass . "           $" . "this->codigo=null ; " .chr(10) ;
		        		$textClass  = $textClass . "           $" . "this->records_found=null ; " .chr(10) ;
		        		$textClass  = $textClass . "       }" .chr(10) ;

						// Numero de linhas da tabela 201
		        		// Todos os set
		        		$textClass  = $textClass . "       function getrecords_found() " . chr(10) . "       {" .chr(10) ;
		        		$textClass  = $textClass . "           if($" . "this->records_found==null) ; " .chr(10) ;
		        		$textClass  = $textClass . "           {" .chr(10) ;
		        		$textClass  = $textClass . "               return 0 ;" .chr(10) ;
		        		$textClass  = $textClass . "           }else{" .chr(10) ;
		        		$textClass  = $textClass . "               return $" . "this->records_found ;" .chr(10) ;
		        		$textClass  = $textClass . "           }" .chr(10) ;
		        		$textClass  = $textClass . "       }" .chr(10) ;
		        		// $textClass  = $textClass . chr(10) ;
		        		for($x=0 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
			        		$textClass  = $textClass . 
			        		"       function set" . $arrayProp[$x] . 
			        		"(". "$" . "_" . $arrayProp[$x] . ")" 
			        		.chr(10). "       {" 
			        		.chr(10). "           " . "$" ."this->" .$arrayProp[$x]. " = $" ."_" .$arrayProp[$x]. " ;" . chr(10) . "       }" . chr(10) ;
			        	}


		        		// Todos os get
		        		for($x=0 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
			        		$textClass  = $textClass . 
			        		"       function get" . $arrayProp[$x] . 
			        		"()" .chr(10). 
			        		"       {" .chr(10). 
			        		"           return " . "$" ."this->" .$arrayProp[$x]. " ;" . chr(10) . 
			        		"       }" . chr(10) ;
			        	}


				        /* metodos de Data Manipulation - Acesso ao SGBD */

				        // Inserir registro novo 209
				        $textClass  = $textClass . "       function inserir" .$class_name. "()".chr(10) . "       {" .chr(10) ;

				        $select = "$" ."mySelect = 'select ";
		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$select = $select .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$select = $select .$arrayProp[ $y ] . " where " ;
		        		$select = $select .$arrayProp[1] . " = ' . $" . "this->" .$arrayProp[1] . " ;" ;

				        $textClass  = $textClass . "           dataBaseAccess() ;". chr(10)  ;
				        $textClass  = $textClass . "           ". $select .chr(10)  ;
				        $textClass  = $textClass . "           $". "ret = mysqli_query($" ."myCon , $" . "mySelect) ;" .chr(10)  ;
				        $textClass  = $textClass . "           $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "           if($". "numRows>0)"  .chr(10). "           {" .chr(10) ;
				        $textClass  = $textClass ."               // Ja cadastrado" .chr(10) ;
				        $textClass  = $textClass ."               mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."               return -1 ; // ja cadastrado ".chr(10) ;
				        $textClass  = $textClass ."           }else{" .chr(10) ;
				        $textClass  = $textClass ."               // Incluir " .chr(10) ;

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
				        $textClass  = $textClass ."               $insert" .chr(10) ;
				        $textClass  = $textClass ."               $" . "ret = mysqli_query($" . "myCon , $". "myInsert) ;" .chr(10) ;
				        $textClass  = $textClass ."               $" . "new_rec = mysqli_insert_id($" . "myCon) ;" .chr(10) ;
				        $textClass  = $textClass ."               return $" . "new_rec ; // se for 0 deu erro na inclusao" .chr(10) ;

				        $textClass  = $textClass ."           }" .chr(10) ;
				        $textClass  = $textClass . "       }" .chr(10) ;

				        
				        // Recuperar // set em todos atributos da classe 379
				        $textClass  = $textClass . "       // Antes de chamar este metodo execute o metodo setCodigo" .chr(10) ;
				        $textClass  = $textClass . "       function recuperar" .$class_name. "()".chr(10) . "       {" .chr(10) ;
				        $textClass  = $textClass . "           $". "_codigo=$". "this->codigo ; " .chr(10) ;
				        $select = "$" ."mySelect = 'select ";
		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$select = $select .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$select = $select .$arrayProp[ $y ] . " where " ;
		        		$select = $select .$arrayProp[0] . " = ' . $" . "this->" .$arrayProp[0] . " ;" ;

				        $textClass  = $textClass . "           dataBaseAccess(); ". chr(10)  ;
				        $textClass  = $textClass . "           ". $select .chr(10)  ;
				        $textClass  = $textClass . "           $". "ret = mysqli_query($" ."myCon , $" . "mySelect) ;" .chr(10)  ;
				        $textClass  = $textClass . "           $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "           if($". "numRows>0)"  .chr(10). "           {" .chr(10) ;
				        $textClass  = $textClass ."               $". "reg = mysqli_fetch_array($". "ret) ;" .chr(10) ;
		        		for($x=1 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
		        			$textClass  = $textClass ."               $". "this->".$arrayProp[$x]. "=$". "reg['" . $arrayProp[$x] ."'] ;" . chr(10);
		        		}
				        $textClass  = $textClass ."               mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass . "              $". "this->records_found=$". "numRows ;" .chr(10) ;
				        $textClass  = $textClass ."               return true ; // ja cadastrado ".chr(10) ;
				        $textClass  = $textClass ."           }else{" .chr(10) ;
				        $textClass  = $textClass ."               mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."               return false ; " .chr(10) ;
				        $textClass  = $textClass . "           }" .chr(10) ;
				        $textClass  = $textClass . "       }" .chr(10) ;



				        // executeSQL 430
				        $textClass  = $textClass . "       function executeSQL" .$class_name. "($" . "_sql)".chr(10) . "       {" .chr(10) ;

				        $textClass  = $textClass . "           $" . "listaObjeto = Array();" . chr(10) ;
				        $textClass  = $textClass . "           if($". "_sql==null)" .chr(10) . "           {" . chr(10) ;
				        $textClass  = $textClass . "               return $". "listaObjeto ;" . chr(10) ;
				        $textClass  = $textClass . "           }" .chr(10) ;
				        $textClass  = $textClass . "           $". "id= -1 ;" .chr(10) ;
				        $textClass  = $textClass . "           dataBaseAccess() ;". chr(10)  ;
				        $textClass  = $textClass . "           $". "ret = mysqli_query($" ."myCon , $" . "_sql) ;" .chr(10)  ;

				        $textClass  = $textClass . "           $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "           if($". "numRows>0)"  .chr(10). "           {" .chr(10) ;
				        $textClass  = $textClass . "               $". "this->records_found=$". "numRows ;" .chr(10) ;
				        $textClass  = $textClass . "               $". "new". $class_name . " = new " . $class_name ." ;" .chr(10) ;
				        $textClass  = $textClass . "               while ($". "row = mysqli_fetch_array($". "ret))" .chr(10). "               {" .chr(10) ;

		        		for($x=1 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
				        	$textClass  = $textClass . "                   $". "new" . $class_name ."->set" . $arrayProp[$x] ."($" ."row['" .$arrayProp[$x]. "']) ;" .chr(10) ;
		        		}
				        $textClass  = $textClass . "                   $". "id += $". "id ;" .chr(10) ;
				        $textClass  = $textClass . "                   $". "listaObjeto[$" . "id] = $". "new" . $class_name . " ;" .chr(10) ;
				        $textClass  = $textClass . "                }" .chr(10) ;
				        $textClass  = $textClass . "           } " .chr(10) ;
				        $textClass  = $textClass . "           mysqli_close( $" . "myCon ) ;" .chr(10) ;
				        $textClass  = $textClass . "           return $" . "listaObjeto ;" .chr(10) ;
				        $textClass  = $textClass . "       }" .chr(10) ;

				        // Buscar - recebe parametros (filtro) e retornar linhas da tabela (vetor) 263

				        // Alterar - 501 (129)
				        $textClass  = $textClass . "       function alterar" .$class_name. "()".chr(10) . "       {" .chr(10) ;

				        $textClass  = $textClass . "           $". "codigo = $". "this->codigo". chr(10)  ;
				        $select = "$" ."mySelect = 'select ";
		        		for($x=0 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$select = $select .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$select = $select .$arrayProp[ $y ] . " where " ;
		        		$select = $select .$arrayProp[0] . " = ' . $" . "this->" .$arrayProp[0] . " ;" ;

				        $textClass  = $textClass . "           dataBaseAccess() ;". chr(10)  ;
				        $textClass  = $textClass . "           ". $select .chr(10)  ;
				        $textClass  = $textClass . "           $". "ret = mysqli_query($" ."myCon , $" . "mySelect) ;" .chr(10)  ;
				        $textClass  = $textClass . "           $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "           if($". "numRows>0)"  .chr(10). "           {" .chr(10) ;


				        $update = "$" ."myUpdae = 'update table " . $class_name  ;
		        		for($x=1 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$update = $update  ." set ". $arrayProp[$x]. "=$" . "this->". $arrayProp[$x] . " , " ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$update = $update .$arrayProp[ $y ] . "= $" . "this->" .$arrayProp[ $y ]. " where " ;
		        		$update = $update .$arrayProp[0] . "=' . $" . "this->" .$arrayProp[0] ;
				        $textClass  = $textClass . "               $update"  .chr(10)  ;


				        $textClass  = $textClass ."               $" ."ret_upd=mysqli_query( $". "myCon , $"."update);"  .chr(10) ;

				        $textClass  = $textClass ."               if( $" ."ret_upd )" . chr(10) ;
				        $textClass  = $textClass ."               {" . chr(10) ;
				        $textClass  = $textClass ."                   mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."                   return true ; // sucesso" . chr(10) ;
				        $textClass  = $textClass ."               }else{ " . chr(10) ;
				        $textClass  = $textClass ."                   mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."                   return false ; // falha " . chr(10) ;
				        $textClass  = $textClass ."               } " . chr(10) ;

				        $textClass  = $textClass ."           }else{" .chr(10) ;
				        $textClass  = $textClass ."               mysqli_close( $". "myCon );" .chr(10) ; 
				        $textClass  = $textClass ."               return false ; // falha na alteracao" .chr(10) ;
				        $textClass  = $textClass ."           } " .chr(10) ;
				        $textClass  = $textClass ."       } " .chr(10) ;

				        // Excluir - 469
				        $textClass  = $textClass . "       function excluir" .$class_name. "()".chr(10) . "       {" .chr(10) ;

				        $textClass  = $textClass . "           $". "codigo = $". "this->codigo". chr(10)  ;
				        $select = "$" ."mySelect = 'select ";
		        		for($x=0 ; $x <= sizeof($arrayProp)-2 ; $x++)
		        		{
		        			$select = $select .$arrayProp[$x]. "," ;
		        		}
		        		$y = sizeof($arrayProp)-1 ;
		        		$select = $select .$arrayProp[ $y ] . " where " ;
		        		$select = $select .$arrayProp[0] . " = ' . $" . "this->" .$arrayProp[0] . " ;" ;

				        $textClass  = $textClass . "           dataBaseAccess() ;". chr(10)  ;
				        $textClass  = $textClass . "           ". $select .chr(10)  ;
				        $textClass  = $textClass . "           $". "ret = mysqli_query($" ."myCon , $" . "mySelect) ;" .chr(10)  ;
				        $textClass  = $textClass . "           $". "numRows= mysqli_num_rows($" . "ret);  " .chr(10)  ;
				        $textClass  = $textClass . "           if($". "numRows>0)"  .chr(10). "           {" .chr(10) ;


				        $delete = "$" ."myDelete = 'delete from " . $class_name . " where " ;
		        		$delete = $update .$arrayProp[0] . "=' . $" . "this->" .$arrayProp[0] ;
				        $textClass  = $textClass . "               $delete"  .chr(10)  ;

				        $textClass  = $textClass ."               $" ."ret_del=mysqli_query( $". "myCon , $"."delete);"  .chr(10) ;
				        $textClass  = $textClass ."               $" ."afected=mysqli_affected_rows( $" . "myCon ) ;" .chr(10) ;
				        $textClass  = $textClass ."               $" ."this->records_found = $" ."afected" ;
				        $textClass  = $textClass ."               if( $" ."afected!=0 )" . chr(10) ;
				        $textClass  = $textClass ."               {" . chr(10) ;
				        $textClass  = $textClass ."                   mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."                   return true ; // sucesso" . chr(10) ;
				        $textClass  = $textClass ."               }else{ " . chr(10) ;
				        $textClass  = $textClass ."                   mysqli_close( $". "myCon );"  .chr(10) ;
				        $textClass  = $textClass ."                   return false ; // falha " . chr(10) ;
				        $textClass  = $textClass ."               } " . chr(10) ;

				        $textClass  = $textClass ."           }else{" .chr(10) ;
				        $textClass  = $textClass ."               mysqli_close( $". "myCon );" .chr(10) ; 
				        $textClass  = $textClass ."               return false ; // falha na alteracao" .chr(10) ;
				        $textClass  = $textClass ."           } " .chr(10) ;
				        $textClass  = $textClass ."       } " .chr(10) ;





				        // fecha a Classe
				        // Criar Classe Conexao
				        $textClass  = $textClass . "    }" .chr(10) .chr(10) ;

				        $inicio     = false   ;
				        $final      = true    ;
				        $class_name = ""      ;
				        $class_pro  = ""      ;
				        $arrayProp  = array() ;				        
		        	}else{
			        	$pi         = strpos($line, "`")       ;
			        	$restoLinha = substr($line, $pi+1)       ;
			        	$pf         = strpos($restoLinha, "`") ;
			        	if($class_name== "")
			        	{
			        		// declaração da Classe
				        	$class_name = substr($restoLinha,0,$pf)  ;
				        	$class_name = strtoupper( substr($class_name,0,1) ) . substr($class_name,1) ;          
				        	$textClass  = $textClass . "   class $class_name" . chr(10); 
				        	$textClass  = $textClass . "   {" .chr(10) ;
			        	}else{
			        		// declaração dos atributos
				        	$class_pro = substr($restoLinha,0,$pf)  ;
				        	$class_pro = strtoupper( substr($class_pro,0,1) ) . substr($class_pro,1) ;
			        		$textClass  = $textClass . "       private $" . "$class_pro ;" .chr(10);
			        		$arrayProp[ sizeof($arrayProp) ] = $class_pro ; 
			        	}   
			        }
		        }
		    }
		    // Encerra o arquivo com todas as classes geradas
		    $textClass  = $textClass .
		    "function dataBaseAccess() " .chr(10).
		    "{" .chr(10).
			"    error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED); " . chr(10).
			"    // error_reporting(0);" .chr(10). 
			"    date_default_timezone_set('America/Recife');" .chr(10).
			"    // conexão com o servidor " .chr(10).
			"    $"."this->myCon = mysqli_connect('localhost', 'userName', 'userPassword');" .chr(10).
			"    return " .chr(10).
			"}" .chr(10) ;

		    $textClass  = $textClass . "?>" ;
		    fclose($fh);
		    fwrite( $fp,$textClass.chr(10).chr(13) ) ;
			fclose( $fp ) ;
			return $this->FileGerated  ;
		}         
      }
    }
?>
