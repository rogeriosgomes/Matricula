<?php
//Dados para conectar no Totvs

$login_integracao ="integracao";
$password =  "int%2*45";
$urltotvs = "https://ws2.thomas.org.br:8051";

//consexãp com DataServer SQL

function conectasql($login_integracao,$password, $urltotvs){
   // $login_integracao ="integracao";
   // $password =  "int%2*45";
   // $urltotvs = $urltotvs;//"https://ws.thomas.org.br:8051";
   $soapParams = array(
           'login' => $login_integracao/*env("USERNAME_WEBSERVICE_TOTVS")*/,
           'password' => $password/*env("PASSWORD_WEBSERVICE_TOTVS")*/,
           'authentication' => SOAP_AUTHENTICATION_BASIC, 
           'trace' => '1', 
           'exceptions' => true,
           'cache_wsdl' => WSDL_CACHE_NONE
       );
       $wsdl =$urltotvs."/wsConsultaSQL/MEX?wsdl";
       $client = new SoapClient($wsdl, $soapParams);

   return $client;
}

//conexão com DataServer
function conectaDataServer($login_integracao,$password, $urltotvs)
   {
     $soapParams = array(
        'login' => $login_integracao/*env("USERNAME_WEBSERVICE_TOTVS")*/,
        'password' => $password/*env("PASSWORD_WEBSERVICE_TOTVS")*/,
        'authentication' => SOAP_AUTHENTICATION_BASIC, 
        'trace' => '1', 
        'exceptions' => true,
        'cache_wsdl' => WSDL_CACHE_NONE
                            );
        $wsdl = $urltotvs."/wsDataServer/MEX?wsd";
        $client = new SoapClient($wsdl, $soapParams);

        return $client;

    }

//Varíavel retorna o codigo da Turma
$codPerlet = '2023/1';
$codTurma = 'AS_ED3';
$ra       = 'BSB018735';

//RETORNA DOS DADOS DA TURMA EM UM ARRAY
$client= conectasql($login_integracao,$password, $urltotvs);

$params = array(
         'codSentenca' =>'MAT.0001', 
         'codColigada'=>1, 
         'codSistema'=>'S', 
         'parameters'=>"CODTURMA=$codTurma;CODPERLET=$codPerlet" 
              
          ); 
 
      
$resultSoap = $client->RealizarConsultaSQL($params);
$result = simplexml_load_string($resultSoap->RealizarConsultaSQLResult);     
$arrayDadosTurma = json_decode(json_encode($result), true);

$codColigada = $arrayDadosTurma["Resultado"]["CODCOLIGADA"];
$idHabilitacaoFilial = $arrayDadosTurma["Resultado"]["IDHABILITACAOFILIAL"];
$codCurso = $arrayDadosTurma["Resultado"]["CODCURSO"];
$codHabilitacao = $arrayDadosTurma["Resultado"]["CODHABILITACAO"];
$codgrade = $arrayDadosTurma["Resultado"]["CODGRADE"];
$codFilial = $arrayDadosTurma["Resultado"]["CODFILIAL"];
$codTurno = $arrayDadosTurma["Resultado"]["CODTURNO"];

// verifica se ja existe o curso habilitacao criado no aluno
$client= conectasql($login_integracao,$password, $urltotvs);
$params = array(
         'codSentenca' =>'MAT.0002', 
         'codColigada'=>1, 
         'codSistema'=>'S', 
         'parameters'=>"CODCOLIGADA=$codColigada;IDHABILITACAOFILIAL=$idHabilitacaoFilial;RA=$ra" 
              
          ); 
       
$resultSoap = $client->RealizarConsultaSQL($params);
$result = simplexml_load_string($resultSoap->RealizarConsultaSQLResult);     
$arrayValidaCursoHabilitacao = json_decode(json_encode($result), true);
$validaCursoHabilitacao = isset($arrayValidaCursoHabilitacao["Resultado"]["Cadastrada"]);

if ($validaCursoHabilitacao == '0') {
    // inclusão do curso/habilitacao
    $client = conectaDataServer($login_integracao,$password, $urltotvs);

    $xml_curso_habilitacao = <<<XML
                                        <EduHabilitacaoAluno>  
                                            <SHabilitacaoAluno>  
                                                <CODCOLIGADA>$codColigada</CODCOLIGADA>  
                                                <IDHABILITACAOFILIAL>$idHabilitacaoFilial</IDHABILITACAOFILIAL>  
                                                <RA>$ra</RA>  
                                                <CODCURSO>$codCurso</CODCURSO>  
                                                <CODHABILITACAO>$codHabilitacao</CODHABILITACAO>  
                                                <CODGRADE>$codgrade</CODGRADE>  
                                                <CODFILIAL>$codFilial</CODFILIAL>  
                                                <CODTURNO>$codTurno </CODTURNO>  
                                            </SHabilitacaoAluno>  
                                        </EduHabilitacaoAluno>
                                    XML;

    $params_curso_habilitacao = array('DataServerName' =>'EduHabilitacaoAlunoData', 
                                    'XML'=>$xml_curso_habilitacao,
                                    'Contexto'=>'CODCOLIGADA=1;CODFILIAL=1;CODTIPOCURSO=1;CODSISTEMA=S;CODUSUARIO=001717');
    $result = $client->SaveRecord($params_curso_habilitacao);

    $req_dump = print_r($result, true );
    $fp = file_put_contents( 'console.json', $req_dump , FILE_APPEND  );
}
else
{
    print("Curso/habilitacao já existia");
}











  
?>
