<?php

	// Inicia sessões 
	session_start(); 

	// Conexão com o banco de dados 
	include("adm/mysqlconfig.inc");
	
	if(isset($_COOKIE["login"]) && $_COOKIE["tipo"] == "assinante"){
	
		$login = $_COOKIE["login"];
		$senha = $_COOKIE["senha"];
	}else{
	
		// Recupera o login 
		$login = isset($_POST["login"])? addslashes(trim($_POST["login"])) : False;
		
		// Recupera a senha, a criptografando em MD5 
		$senha = isset($_POST["senha"])? md5(trim($_POST["senha"])) : False;	
		
	}
	/** * Executa a consulta no banco de dados. 
		* Caso o número de linhas retornadas seja 1 o login é válido, 
		* caso 0, inválido. 
	*/ 
		
	$sql = "select * from assinantes where email='$login';";
	
	$result_id = mysql_query($sql) or die("Erro no banco de dados!"); 
	$total = mysql_num_rows($result_id); 
	
	// Caso o usuário tenha digitado um login válido o número de linhas será igual ou maior que 1.. 
	if($total){
	
		// Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão 
		$dados = mysql_fetch_array($result_id); 

		// Agora verifica a senha
		if(!strcmp($senha, $dados["senha"])){
			$status;
			
			if($dados['status'] == 1){			
				// TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário 
				$_SESSION["id"] = $dados["id"]; 
				$_SESSION["nome"] = stripslashes($dados["nome"]); 
				$_SESSION["nivel"] = "0"; 
				
				// VERIFICA SE O BOTAO LEMBRAR TA ATIVO
				if(isset($_POST['remember'])){
					echo "DENTRO";
					$tempo_expiracao= time()+3600*24*5; //uma hora
					setcookie("tipo", "assinante", $tempo_expiracao);
					setcookie("login", $login, $tempo_expiracao);
					setcookie("senha", $senha, $tempo_expiracao);
				}
				
				header("Location: index.php"); 
			}else{
				echo "<script> var a = confirm('Usuario desativado. Deseja reativar?');
						if(a == false){
							Location: location.href='index.php';
						}else{
							Location: location.href='ativar.php?id=$dados[id]';
						}
					</script>";
				exit;				
			}
		} 
		// Senha inválida 
		else{
		
			echo "<script> alert('Senha Inválida'); Location: javascript:history.back(); </script>"; 
			exit; 
		} 
	} 
	// Login inválido 
	else{ 
		echo "<script> alert('O login fornecido por você é inexistente $login'); Location: javascript:history.back();</script>"; 
		exit; 
	}
?>