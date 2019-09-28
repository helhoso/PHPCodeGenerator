<?php
	// https://github.com/
	class Gerar{
		private $arquivoSQL ;
		private $arquivoOBJ ;
		public  $inicio     ;
		public  $final      ;

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

		$textClass = "" ;
		$fp = fopen("ClassesPHP.txt","a");

      	$inicio = false ;
      	$final  = true  ;
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
		        	$final  = true  ;
		        	$inicio = false ;
		        	echo ("</br></br>");
		        }
		        if($inicio && !$final)
		        {
		        	echo ("$line </br>");
		        	$textClass = $textClass . $line .chr(10).chr(13) ;
		        }
		        // echo ("$line </br>");
		    }
		    fclose($fh);
		    fwrite( $fp,$textClass.chr(10).chr(13) ) ;
			fclose( $fp ) ;
		}         
      }
  }

?>