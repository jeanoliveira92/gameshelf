		<?php include("header.php"); 
		
			if($_SESSION["tipo"] > 1){ 
				//se não há erro, exibe a msg
				echo"<script> alert('Você não possui permissões para esta ação.'); Location: javascript:history.back(); </script>";
			}
			
			if(isset($_GET['id'])){			
				$id = $_GET['id'];

				$sql = "select id from assinantes";
				// implementar depois o select id from usuario where id='$id';
				
				$query = mysql_query($sql) or die(mysql_error());

				while($ID = mysql_fetch_array($query)){
					$temp = md5(trim($ID['id']));
					
					if($id == $temp){				
						$id = $ID["id"];
						break;
					}
				}
				
				// SETANDO CLIENT NO FORMULARIO
				
				$sql ="select * from assinantes where id='$id'";		
				$query = mysql_query($sql) or die("Deu erro".mysql_error());

				$dados = mysql_fetch_array($query);	
			}
		?>
		<div class="wrapper" role="main">
			<div class="container">
				<div class="row">
				<?php include("left-sidebar.php"); ?>
					<div class="col-md-9">
						<div class="col-md-12">
							<form method="post" data-toggle="validator"  id="cadastraUsuario" name="cadastraUsuario" 
							<?php	if(isset($id)){	echo "action='cadastraAssinante.php?opt=update&id=$_GET[id]'";}
									else{			echo "action='cadastraAssinante.php'";}						
							?>>
							<?php
							if(isset($id)){
								echo "
								<fieldset class='form-group'>
									<div class='row'>
										<div class='form-group col-md-5'>
											<label for='nome'>Nome:</label>
											<input type='text' class='form-control' name='nome' value='$dados[nome]'>
										</div>
									</div>
									<div class='row'>
										<div class='form-group col-md-5'>
											<label for='e-mail'>E-mail:</label>
											<input type='email' class='form-control'  name='email' value='$dados[email]'>
										</div>
										<div class='form-group col-md-5'>
											<label for='email2'>Repita o e-mail:</label>
											<input type='email' class='form-control' name='email2' data-error='Confirme o e-mail.' required>
												<div class='help-block with-errors'></div>
										</div>
									</div>
									<div class='row'>
										<div class='form-group col-md-12'>
											<label for='campo1'>Selecione caso deseje alterar a senha:</label>
											<div class='radio' style='display: inline;'>
											  <label class='radio-inline'>
												<input type='checkbox' name='vSenha' > Alterar Senha
											  </label>
											</div>
										</div>
									</div>
									<div class='row'>
										<div class='form-group col-md-5'>
											<label for='senha'>Senha:</label>
											<input type='password' class='form-control' name='senha'>
										</div>
										<div class='form-group col-md-5'>
											<label for='senha2'>Repita a senha:</label>
											<input type='password' class='form-control' name='senha2'>
										</div>
									</div>	
								</fieldset>			
								<button type='submit' class='btn btn-primary'>Alterar</button>";
							}
							?>
								<a class="btn btn-default" onclick="Location: javascript:history.back();">Voltar</a>
							</form>

						<?php include("footer.php"); ?>
						