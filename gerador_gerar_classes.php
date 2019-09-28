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
		        		for($x=0 ; $x <= sizeof($arrayProp)-1 ; $x++)
		        		{
			        		$textClass  = $textClass . 
			        		"       function set" . $arrayProp[$x] . 
			        		"(". "$" . "_" . $arrayProp[$x] . ")" 
			        		.chr(10). "       {" 
			        		.chr(10). "           " . "$" ."this->" .$arrayProp[$x]. " = $_" 
			        		.$arrayProp[$x]. chr(10) . "       }" . chr(10) ;
			        	}
				        $textClass  = $textClass . "   }" .chr(10) ;
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
				        	$textClass  = $textClass . "   class $class_name" . "{" .chr(10) ;
			        	}else{
				        	$class_pro = substr($restoLinha,0,$pf)  ;
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
