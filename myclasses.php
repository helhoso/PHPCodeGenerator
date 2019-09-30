<?php
/* 
   Programm: gerador_classes.php
   Objective: Gerar classes em PHP oritenado a objeto a partir de um arquivo texto sql
   Autor: Hélio Barbosa
   Todas as classes serão criadas em um unico arquivo separe-as posteriormente
   GitHub: https://github.com/helhoso/PHPCodeGenerator.git
   linkedin: https://br.linkedin.com/in/helio-barbosa-32718082
   email: hflb01@gmail.com
   youtube: https://www.youtube.com/user/1908HELIO
*/

   class Usuario
   {
       private $Codigo ;
       private $Codigo_empresa ;
       private $Nome ;
       private $Senha ;
       private $records_found ;
       private $myCon ; // conexao com Banco de dados 

    function dataBaseAccess() 
    {
        error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED); 
        // error_reporting(0);
        date_default_timezone_set('America/Recife');
        // conexão com o servidor 
        $this->myCon=mysqli_connect("localhost", "X", "X");
        $db_selected = mysqli_select_db( $this->myCon , 'D' );
        return ; 
    }
       function __construct() 
       {
           $this->codigo=null ; 
           $this->records_found=null ; 
       }
       function __destruct() 
       {
           $this->codigo=null ; 
           $this->records_found=null ; 
       }
       function getrecords_found() 
       {
           if($this->records_found==null) 
           {
               return 0 ;
           }else{
               return $this->records_found ;
           }
       }
       function setCodigo($_Codigo)
       {
           $this->Codigo = $_Codigo ;
       }
       function setCodigo_empresa($_Codigo_empresa)
       {
           $this->Codigo_empresa = $_Codigo_empresa ;
       }
       function setNome($_Nome)
       {
           $this->Nome = $_Nome ;
       }
       function setSenha($_Senha)
       {
           $this->Senha = base64_encode( $_Senha );
       }
       function getCodigo()
       {
           return $this->Codigo ;
       }
       function getCodigo_empresa()
       {
           return $this->Codigo_empresa ;
       }
       function getNome()
       {
           return $this->Nome ;
       }
       function getSenha()
       {
           return $this->Senha ;
       }
       public function inserirUsuario()
       {
           $this->dataBaseAccess() ;
           $mySelect = 'select Nome,Senha from usuario where Nome="' . $this->Nome .'" and Senha="'. $this->Senha .'"';
           // echo $mySelect ."</br>";
           $ret = mysqli_query($this->myCon , $mySelect) ;
           if( $ret->num_rows>0 )
           {
               // Ja cadastrado
               mysqli_close( $this->myCon );
               return 0 ; // ja cadastrado 
           }else{
               // Incluir 
               $myInsert = 'insert into Usuario (Codigo_empresa,Nome,Senha) values ('.$this->Codigo_empresa.',"'.$this->Nome.'","'.$this->Senha.'")' ; 
               // echo $myInsert . "</br>";
               $ret = mysqli_query($this->myCon , $myInsert) ;
               $new_rec = mysqli_insert_id($this->myCon) ;
               return $new_rec ; // se for 0 deu erro na inclusao
           }
       }
       // Antes de chamar este metodo execute o metodo setCodigo
       function recuperarUsuario()
       {
           $_codigo=$this->codigo ; 
           $this->dataBaseAccess(); 
           $mySelect = 'select Codigo_empresa,Nome,Senha where Codigo = ' . $this->Codigo ;
           $ret = mysqli_query($this->myCon , $mySelect) ;
           $numRows= mysqli_num_rows($ret);  
           if($numRows>0)
           {
               $reg = mysqli_fetch_array($ret) ;
               $this->Codigo_empresa=$reg['Codigo_empresa'] ;
               $this->Nome=$reg['Nome'] ;
               $this->Senha=$reg['Senha'] ;
               mysqli_close( $this->myCon );
              $this->records_found=$numRows ;
               return true ; // ja cadastrado 
           }else{
               mysqli_close( $this->myCon );
               return false ; 
           }
       }
       function executeSQLUsuario($_sql)
       {
           $listaObjeto = Array();
           if($_sql==null)
           {
               return $listaObjeto ;
           }
           $id= -1 ;
           $this->dataBaseAccess() ;
           $ret = mysqli_query($this->myCon , $_sql) ;
           $numRows= mysqli_num_rows($ret);  
           if($numRows>0)
           {
               $this->records_found=$numRows ;
               $newUsuario = new Usuario ;
               while ($row = mysqli_fetch_array($ret))
               {
                   $newUsuario->setCodigo_empresa($row['Codigo_empresa']) ;
                   $newUsuario->setNome($row['Nome']) ;
                   $newUsuario->setSenha($row['Senha']) ;
                   $id += $id ;
                   $listaObjeto[$id] = $newUsuario ;
                }
           } 
           mysqli_close( $this->myCon ) ;
           return $listaObjeto ;
       }
       function alterarUsuario()
       {
           $codigo = $this->codigo ;
           $this->dataBaseAccess() ;
           $mySelect = 'select Codigo,Codigo_empresa,Nome,Senha where Codigo = ' . $this->Codigo ;
           $ret = mysqli_query($this->myCon , $mySelect) ;
           $numRows= mysqli_num_rows($ret);  
           if($numRows>0)
           {
               $myUpdae = 'update table Usuario set Codigo_empresa=$this->Codigo_empresa ,  set Nome=$this->Nome , Senha= $this->Senha where Codigo=' . $this->Codigo ;
               $ret_upd=mysqli_query( $this->myCon , $update);
               if( $ret_upd )
               {
                   mysqli_close( $this->myCon );
                   return true ; // sucesso
               }else{ 
                   mysqli_close( $this->myCon );
                   return false ; // falha 
               } 
           }else{
               mysqli_close( $this->myCon );
               return false ; // falha na alteracao
           } 
       } 
       function excluirUsuario()
       {
           $codigo = $this->codigo ;
           $this->dataBaseAccess() ;
           $mySelect = 'select Codigo,Codigo_empresa,Nome,Senha where Codigo = ' . $this->Codigo ;
           $ret = mysqli_query($this->myCon , $mySelect) ;
           $numRows= mysqli_num_rows($ret);  
           if($numRows>0)
           {
               $myDelete = 'delete from Usuario where Codigo=' . $this->Codigo ;
               $ret_del=mysqli_query( $this->myCon , $myDelete);
               $afected=mysqli_affected_rows( $this->myCon ) ;
               $this->records_found = $afected ;
               if( $afected!=0 )
               {
                   mysqli_close( $this->myCon );
                   return true ; // sucesso
               }else{ 
                   mysqli_close( $this->myCon );
                   return false ; // falha 
               } 
           }else{
               mysqli_close( $this->myCon );
               return false ; // falha na alteracao
           } 
       } 
    }

?>
