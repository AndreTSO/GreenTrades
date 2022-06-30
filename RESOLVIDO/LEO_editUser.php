<!DOCTYPE html>
<html lang="pt">
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/leo.css">
    

	<?php 
		include("includes/config.php");
		
		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT


	?>


	<script>

		function obtemDistrito(){
				let codigo = $('#distrito option:selected').val();
				$.ajax({
				type: "POST",
				url: 'ajax_district.php',
				data: {distrito: codigo},
				dataType: "html",
				success: function (data){
						if (data) {
							document.getElementById('conselho2').innerHTML = data;
						}
					}
				});
			}

		function pw(){
			registo.senha2.setAttribute('pattern', registar.senha.value);
		}
			
		function registar(){
			//EXEMPLO DE AJAX -> var telefone = ($("#telefone").val())
			let senha = document.getElementById("senha1").value;
			let senha2 = document.getElementById("senha2").value;

			if (senha==senha2){
				console.log("Entrei");
				let nif = document.getElementById("nif").value;
				let nome = document.getElementById("nome").value;
				let sobreNome = document.getElementById("sobreNome").value;
				let genero = document.querySelector('input[name="genero"]:checked').value;
				let email = document.getElementById("email").value;
				let morada = document.getElementById("morada").value;
				let codigoPostal = document.getElementById("codPostal").value;
				let distrito = document.getElementById("distrito").value;
				let concelho = document.getElementById("concelho").value;
				let dataNasc = document.getElementById("dataNasc").value;
				let tipoConta = document.querySelector('input[name="tipoConta"]:checked').value;
				let tlf = document.getElementById("tlf").value;
				let anuncios = document.querySelector('input[name="anuncios"]:checked').value;
				
				$.ajax({
					type: "POST",
					url: 'ajax_user.php',
					data: {
						codigo: 1,
						nif: nif,
						nome: nome,
						sobreNome: sobreNome,
						genero: genero,
						email: email,
						senha: senha,
						morada: morada,
						codigoPostal: codigoPostal,
						distrito: distrito,
						concelho:concelho,
						dataNascimento:dataNasc,
						tipoConta:tipoConta,
						contacto:tlf,
						anuncios:anuncios,
						},
					dataType: "html",
					success: function (data){
							if (data) {
								
								document.getElementById('atualiza').innerHTML = data;

							}else{
								alert("Erro no Registo")

							}
						}
					});

			}else{
				alert("Somehow A senha nao é correcta ALTEREM ME DEPOIS");
			}
		}

	</script>
    <?php  
        include 'showMsg.php';
        //$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""

        ?>
        <?php 
        $resultado = $ctrlUser->getTodosOsDados($_SESSION['nif']);
    ?>


	
</head>
<body>
<div class="container emp-profile">
    <div class="row">
        <div class="col-md-6">
            <div class="profile-head">
                <h4>
                    <p>Bem-Vindo</p>
                </h4>
                <h6>
                <?php echo ($resultado['tipoDeConta']== 1?"Utilizador": ($resultado['tipoDeConta'] == 2?  "Fornecedor":($resultado['tipoDeConta'] == 3?  "Transportador": "Administrador" ) ))?>
                </h6>
                <p class="proile-rating">AVALIAÇAO : <span>5 estrelas</span></p>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="perfil-tab" data-toggle="tab"  role="tab" aria-controls="perfil" aria-selected="true" style="color:black;">Perfil</a>
                    </li>
                </ul>               
            </div>
        </div>
    </div>
    <!-- PERFIL -->
    <div class="tab-pane fade show active" id="perfil" role="tabpanel" aria-labelledby="perfil-tab">
        <form  METHOD="POST" ACTION="ajax_user.php" name="registar">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nome</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="nome" name="nome" type="text" value="<?php echo $resultado['nome']; ?>" required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Sobrenome</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="nome" name="nome" type="text" value="<?php echo $resultado['sobreNome']; ?>" required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Genero</label>
                    </div>
                    <div class="col-md-6">
                        <select name = 'genero' id = 'genero' class="form-select" required>							
                            <option required value='M' selected >Masculino</option>
                            <option required value='F'>Feminino</option>
                            <option required value='O'>Não Declarar</option>
						</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Email</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="email" name="email" type="email" value="<?php echo $resultado['email']; ?>" required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Senha</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="senha1" autocomplete="off" name="senha" type="password" value="" placeholder="Prencher para alterar" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="8 Digitos Min 1 numero, Min 1 Maiuscula, min 1 Minuscula"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Repetir Senha</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="senha2" autocomplete="off" name="senha2" type="password" value="" onchange="pw()"  placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Morada</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="morada" name="morada" type="text" value="<?php echo $resultado['morada']; ?>" required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Codigo Postal</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="codPostal" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="<?php echo $resultado['codigoPostal']; ?>"required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Distrito</label>
                    </div>
                    <div class="col-md-6">
                        <p><select name='distrito' id='distrito' onChange='obtemDistrito()' required >
					<?php
					$resultado2=$ctrldistrict->getDistrict($db);
					
					echo "<option value=''>Distrito</option>";
					if ($resultado2 && $resultado2->RecordCount()>0){
						
						while ($linha=$resultado2->FetchRow()){
							echo "<option ".($resultado['distrito']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
							
						}
					}
					?>
				</select></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Concelho</label>
                    </div>
                    <div class="col-md-6">
                        <p><span id="conselho2">
                    <select name='concelho' id='concelho'  required >    
                    <?php
                        $resultado2=$ctrldistrict->getConcelhoByDistrictId($db, $resultado['distrito']);
                        
                        echo "<option value=''>Concelho</option>";
                        if ($resultado2 && $resultado2->RecordCount()>0){
                            
                            while ($linha=$resultado2->FetchRow()){
                                echo "<option ".($resultado['concelho']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
                                
                            }
                        }
                        ?>
                    </select>


				</span></p>
                    </div>
                </div>
                <input id="nif" name="nif" type="hidden"  value="<?php echo $resultado['nif']; ?>" pattern="\d{9}" title="Numero de contribuinte com 9 digitos" required placeholder="">
                <div class="row">
                    <div class="col-md-6">
                        <label>Contacto</label>
                    </div>
                    <div class="col-md-6">
                        <p><input id="tlf" name="contacto" type="text" pattern="\d{9}" value="<?php echo $resultado['contato']; ?>" title="Numero de telefone com 9 digitos" required placeholder=""></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Data Nascimento</label>
                    </div>
                    <div class="col-md-6">
                        <p><?php echo $resultado['dataNascimento'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Observações</label>
                    </div>
                    <div class="col-md-6">
                        <p><?php echo (trim($resultado['observacoes'])==""?"Sem observações":$resultado['observacoes']) ?></p>
                    </div>
                </div>
                <input type="submit" value="Guardar">
            <!-- <button type="submit" class="btn btn-outline-success"><a href='LEO_editUser.php' style="text-decoration: none; color: green;">Editar dados</a></button> -->
        </form>
    </div>

</div>
</body>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
