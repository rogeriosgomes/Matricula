<?php
//Dados para conectar no Totvs

$login_integracao ="integracao";
$password =  "int%2*45";
$urltotvs = "https://ws2.thomas.org.br:8051";

function conectaProcesso($login_integracao,$password, $urltotvs)
   {
     $soapParams = array(
        'login' => $login_integracao/*env("USERNAME_WEBSERVICE_TOTVS")*/,
        'password' => $password/*env("PASSWORD_WEBSERVICE_TOTVS")*/,
        'authentication' => SOAP_AUTHENTICATION_BASIC, 
        'trace' => '1', 
        'exceptions' => true,
        'cache_wsdl' => WSDL_CACHE_NONE
                            );
        $wsdl = $urltotvs."/wsProcess/MEX?wsdl";
        //wsProcess/MEX?wsdl";
        $client = new SoapClient($wsdl, $soapParams);

        return $client;

    }

    $client = conectaProcesso($login_integracao,$password, $urltotvs);

    $xml_Processo_Matricula =
    '<?xml version="1.0" encoding="UTF-8"?>
    <EduMatriculaParamsProc xmlns="http://www.totvs.com.br/RM/" xmlns:i="http://www.w3.org/2001/XMLSchema-instance" xmlns:z="http://schemas.microsoft.com/2003/10/Serialization/" z:Id="i1">
       <Context xmlns="http://www.totvs.com/" xmlns:a="http://www.totvs.com.br/RM/" z:Id="i2">
          <a:_params xmlns:b="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
             <b:KeyValueOfanyTypeanyType>
                <b:Key xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">$CODTIPOCURSO</b:Key>
                <b:Value xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:int">1</b:Value>
             </b:KeyValueOfanyTypeanyType>
             <b:KeyValueOfanyTypeanyType>
                <b:Key xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">$CODCOLIGADA</b:Key>
                <b:Value xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:int">1</b:Value>
             </b:KeyValueOfanyTypeanyType>
             <b:KeyValueOfanyTypeanyType>
                <b:Key xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">$CODSISTEMA</b:Key>
                <b:Value xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">S</b:Value>
             </b:KeyValueOfanyTypeanyType>
             <b:KeyValueOfanyTypeanyType>
                <b:Key xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">$CODUSUARIO</b:Key>
                <b:Value xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">001717</b:Value>
             </b:KeyValueOfanyTypeanyType>
             <b:KeyValueOfanyTypeanyType>
                <b:Key xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:string">$CODFILIAL</b:Key>
                <b:Value xmlns:c="http://www.w3.org/2001/XMLSchema" i:type="c:int">1</b:Value>
             </b:KeyValueOfanyTypeanyType>
          </a:_params>
          <a:Environment>DotNet</a:Environment>
       </Context>
       <PrimaryKeyList xmlns="http://www.totvs.com/" xmlns:a="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
          <a:ArrayOfanyType>
             <a:anyType xmlns:b="http://www.w3.org/2001/XMLSchema" i:type="b:short">1</a:anyType>
             <a:anyType xmlns:b="http://www.w3.org/2001/XMLSchema" i:type="b:int">754</a:anyType>
             <a:anyType xmlns:b="http://www.w3.org/2001/XMLSchema" i:type="b:string">BSB018735</a:anyType>
          </a:ArrayOfanyType>
       </PrimaryKeyList>
       <PrimaryKeyNames xmlns="http://www.totvs.com/" xmlns:a="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
          <a:string>CODCOLIGADA</a:string>
          <a:string>IDHABILITACAOFILIAL</a:string>
          <a:string>RA</a:string>
       </PrimaryKeyNames>
       <MatricPLParams z:Id="i3">
       <CadastrarContrato>true</CadastrarContrato>
       <CodColigada>1</CodColigada>
       <CodFilial>1</CodFilial>
       <CodPlanoPgto>1.001</CodPlanoPgto>
       <CodStatus>3</CodStatus>
       <CodTipoCurso>1</CodTipoCurso>
       <CodTipoMat>1</CodTipoMat>
       <CodTurma>AS_ED3</CodTurma>
       <CodUsuario>001717</CodUsuario> 
       <DataMatricula>2023-01-12T15:28:39.6617966-03:00</DataMatricula>
       <DiaFixo>Nao</DiaFixo>
       <DiasVencimentoPrimeiraParcela>0</DiasVencimentoPrimeiraParcela>
          <Disciplinas>
             <EduMatriculaDiscParams>
                <CodColigada>1</CodColigada>
                <CodFilial>1</CodFilial>
                <CodStatus>3</CodStatus>
                <CodTipoCurso>1</CodTipoCurso>
                <CodUsuario>001717</CodUsuario>
                <DataMatricula>2022-12-20T08:54:33.5407253-03:00</DataMatricula>
                <GerarLogMatricPL>false</GerarLogMatricPL>
                <IdHabilitacaoFilial>754</IdHabilitacaoFilial>
                <IdPerLet>156</IdPerLet>
                <IdTurmaDisc>17245</IdTurmaDisc>
                <RA>BSB018735</RA>
                <TipoDisciplina>Normal</TipoDisciplina>
                <TipoMat>3</TipoMat>
             </EduMatriculaDiscParams>
          </Disciplinas>
          <GerarLog>true</GerarLog>
          <IdHabilitacaoFilial>754</IdHabilitacaoFilial>
          <IdPerLet>156</IdPerLet>
          <Periodo>4</Periodo>
          <RA>BSB018735</RA>
       </MatricPLParams>
       <MatricularDisc>Nao</MatricularDisc>
    </EduMatriculaParamsProc>
    ';

   // echo($xml_Processo_Matricula);
                                

    $params_matricula = array('ProcessServerName' =>'EduMatriculaProcData', 
                               'strXmlParams'=>$xml_Processo_Matricula);
    $execute = $client->ExecuteWithXmlParams($params_matricula);
    $result= $execute ->ExecuteWithXmlParamsResult;
    print_r($result);
/*
$execute = $client->ExecuteWithXmlParamsAsync([
  'ProcessServerName' => 'EduMatriculaProcData',
  'strXmlParams'      => $xml_Processo_Matricula
]);

$result = $execute ->ExecuteWithXmlParamsAsyncResult;

print_r($result);*/




?>