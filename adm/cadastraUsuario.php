<?php
	// Conex�o com o banco de dados 
	include("mysqlconfig.inc");
	
	// Inicia sess�es 
	session_start();
	
	$nome	= $_POST['nome'];
	$email	= $_POST['email'];
	$senha	= $_POST['senha'];
	$tipo	= $_POST['tipo'];

	//variavel que informar� a ocorrencia de erros
	$erro = 0;
	
	if(empty($nome)){
		$erro = 1;
		$msg = " INFORME O NOME";
		
	}else if(empty($email)){
		$erro = 1;
		$msg = " INFORME SEU E-MAIL";
		
	}else if($_POST['email'] != $_POST['email2']){
		$erro = 1;
		$msg = " E-MAILS DIFERENTES";
		
	}else if(strlen($email)<7 || substr_count($email,"@")!=1 || substr_count($email,".")==0){
		//verifica tamanho m�nimo do e-mail e se existe "@" e ponto.
		$erro = 1;
		$msg = "E-MAIL N�O FOI DIGITADO CORRETAMENTE"; 
		
	}else if(empty($senha)){
		$erro = 1;
		$msg = " INFORME A SENHA";
		
	}else if($_POST['senha'] !=  $_POST['senha2']){
		$erro = 1;
		$msg = " SENHAS DIFERENTES";
		
	}else if($tipo <= 0 || $tipo >= 3){
		$erro = 1;
		$msg = " INFORME O TIPO DE USUARIO";
		
	}		
	
	if($erro > 0){
		//se n�o h� erro, exibe a msg
		echo"<script> alert('$msg'); Location: javascript:history.back(); </script>";
			
	}else{
		
		$senha = md5(trim($senha));
	
		//aqui podemos realizar o tratamento das informa��es. ex: gravando em um arquivo ou banco de dados
			$sql = "insert into usuarios values('NULL','$nome','$senha', '$email', $tipo)";
		
		$result_id = mysql_query($sql) or die("<script> alert('Erro no banco de dados! Location: javascript:history.back(); </script>"); 
		//$total = mysql_num_rows($result_id);
		

		$msg = "Cadastro realizado com suceso";
		echo"<script> alert('$msg'); Location: location.href='caduser.php';</script>";

	}
?>