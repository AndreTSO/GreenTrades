<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenTrades</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/botoes.css">    

	<?php 
		include("includes/config.php");
        if(!isset($_POST['idArmazem'])){
            header('Location: showArmazem.php');
        }

		

		include'classes/district.php';
		$ctrldistrict=new handlerDistrict();	

        include 'classes/armazem.php';
        $ctrlArmazem=new armazem($db);
        
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

	</script>


	
</head>
<body>
	<div class="body">
		<?php 
     		include 'topo.php';

     	?>
        <div class="page">
		    <div class="content">
				<div class="contentTitle">
					<h2>Editar Armazém</h2>
                    <hr class="middle">
                </div>
			    <?php  

				    include 'showMsg.php';
                    //$nif, $nome, $sobreNome, $genero, $email, $morada, $codigoPostal, $distrito, $concelho, $dataNascimento,  $contacto, $anuncios, $senha=""
			
			    ?>
                <?php 
                    $resultado = $ctrlArmazem->getTodosOsDados($_POST['idArmazem']);
                ?>

                <center>
				<h6><em>Apenas altere os dados necessários.</em></h6>
				</center>
				
			    <form  METHOD="POST" ACTION="ajax_fornecedor.php">
				    <input type="hidden" name="codigo" value=5>
				    <input type="hidden" name="idArmazemFornecedor" value=<?php echo $resultado['idArmazemFornecedor']?>>
				    <input type="hidden" name="idFornecedor" value=<?php echo $resultado['idFornecedor']?>>

					<!-- <label><strong><em>Nome do Armazém: &nbsp </em></strong></label>
				    <input id="nome" name="nome" class="form-control" type="text" value="'.$resultado['nome'].'" required placeholder="">
				    <br>

					<label><strong><em>Morada do Armazém: &nbsp </em></strong></label>
				    <input id="morada" name="morada" class="form-control" value="'.$resultado['morada'].'" type="text" required placeholder="">
				    <br>

					<label><strong><em>Nº da Porta: &nbsp </em></strong></label>
				    <input id="nPorta" name="nPorta" class="form-control" value="'.$resultado['nPorta'].'" type="number" required placeholder="">
				    <br>
					
					<label><strong><em>Nº/Identificador do Armazém: &nbsp </em></strong></label>
				    <input id="andar" name="andar" class="form-control" value="'.$resultado['andar'].'" type="text" required placeholder="">
				    <br>

					<label><strong><em>Código Postal: &nbsp </em></strong></label>
					<input id="codigoPostal" class="form-control" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="'.$resultado['codigoPostal'].'"required placeholder="">
					<br>

					<label><strong><em>Distrito: &nbsp </em></strong></label>
					<select name='distrito' class="form-control" id='distrito' onChange='obtemDistrito()' required >
						<?php
						$resultado2=$ctrldistrict->getDistrict($db);
						
						echo "<option value=''>Distrito</option>";
						if ($resultado2 && $resultado2->RecordCount()>0){
							
							while ($linha=$resultado2->FetchRow()){
								echo "<option ".($resultado['distrito']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
								
							}
						}
						?>
					</select>
					<br>

					<label><strong><em>Concelho: &nbsp </em></strong></label>
					<span id="conselho2">
						<select name='concelho' class="form-control" id='concelho'  required >    
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
					</span>
					<br>

					<label><strong><em>Custo de Manutenção: &nbsp </em></strong></label>
				    <input id="custoManutencao" class="form-control" name="custoManutencao" type="number" value="'.$resultado['custoManutencao'].'" required placeholder="">
				    <br>

					<label><strong><em>Estado: &nbsp </em></strong></label>
                    	<select class="form-control" name="estado">
				        	<option name="estado" required value="34" <?php echo ($resultado['estado']=='34' ?"checked":""); ?> > Ativo
				        	<option name="estado" required value="35" <?php echo ($resultado['estado']=='35' ?"checked":""); ?> > Encerrado
							<option name="estado" required value="36" <?php echo ($resultado['estado']=='36' ?"checked":""); ?> > Indisponivel
						</select>
					<br> -->

					<?php
                    
                    echo '<div class="container rounded bg-white mt-5 mb-5">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><span class="font-weight-bold"></span><span class="text-black-50"></span><span> </span></div>
                            </div>
                            <div class="col-md-5 border-right">
                                <div class="p-3 py-5">
                                    
                                    
                                    <div class="row mt-1">
                                        <div class="col-md-12"><label class="labels"><strong><em>Nome do Armazem:&nbsp</em></strong></label><input id="nome" name="nome" class="form-control" type="text" value="'.$resultado['nome'].'" required placeholder=""></div><br>
                                        <div class="col-md-12"><label class="labels"><strong><em>Morada do Armazem:  &nbsp&nbsp</em></strong></label><input id="morada" name="morada" class="form-control" value="'.$resultado['morada'].'" type="text" required placeholder=""></div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Porta:  &nbsp&nbsp</em></strong></label><input id="nPorta" name="nPorta" class="form-control" value="'.$resultado['nPorta'].'" type="number" required placeholder=""></div>
										<div class="col-md-12"><label class="labels"><strong><em>Nº Identificador:  &nbsp&nbsp</em></strong></label><input id="andar" name="andar" class="form-control" value="'.$resultado['andar'].'" type="text" required placeholder=""></div>
										<div class="col-md-12"><label class="labels"><strong><em>Distrito da Sede:  &nbsp&nbsp</em></strong></label><select name="distrito" class="form-control" id="distrito" onChange="obtemDistrito()" required >';
										
										$resultado2=$ctrldistrict->getDistrict($db);
										
										echo "<option value=''>Distrito</option>";
										if ($resultado2 && $resultado2->RecordCount()>0){
											
											while ($linha=$resultado2->FetchRow()){
												echo "<option ".($resultado['distrito']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
												
											}
										}
										
									echo'</select></div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Concelho da Sede:  &nbsp&nbsp</em></strong></label><span id="conselho2">
										<select name="concelho" class="form-control" id="concelho"  required > ';  
										
											$resultado2=$ctrldistrict->getConcelhoByDistrictId($db, $resultado['distrito']);
											
											echo "<option value=''>Concelho</option>";
											if ($resultado2 && $resultado2->RecordCount()>0){
												
												while ($linha=$resultado2->FetchRow()){
													echo "<option ".($resultado['concelho']==$linha['id']?"selected":"")." value='".$linha['id']."'>".$linha['name']."</option>";
													
												}
											}
											
										echo'</select>
										</span></div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Código Postal:  &nbsp&nbsp</em></strong></label><input id="codigoPostal" class="form-control" name="codigoPostal"  pattern="\d{4}-\d{3}" title="DDDD-DDD" type="text" value="'.$resultado['codigoPostal'].'"required placeholder=""></div>
                                    </div>
                                    <hr>
                                    <div class="row mt-2">
                                        <div class="col-md-12"><label class="labels"><strong><em>Custo de Manutencao: &nbsp&nbsp </em></strong></label><input id="custoManutencao" class="form-control" name="custoManutencao" type="number" value="'.$resultado['custoManutencao'].'" required placeholder=""><strong><em>&nbsp €</em></strong></div>
                                        <div class="col-md-12"><label class="labels"><strong><em>Estado:  &nbsp&nbsp</em></strong></label><select class="form-control" name="estado">
											<option name="estado" required value="34" '.($resultado['estado']=='34' ?"checked":"").' > Ativo
											<option name="estado" required value="35" '.($resultado['estado']=='35' ?"checked":"").' > Encerrado
											<option name="estado" required value="36" '.($resultado['estado']=='36' ?"checked":"").' > Indisponivel
										</select></div>
                                    </div>
                                    
                                    
                                    ';
                                    ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
					<input type="hidden" name="poluicaoGerada" value="<?php echo $resultado['poluicaoGerada']?>">
					<center>						
					<input type="submit" value="Guardar" class="btnUser">
					</center>
					<span id="atualiza"></span><br>
				
				</form>
				<hr>
				<center>
				<div class="opções">
					<form ACTION="mostrarDadosArmazem.php" METHOD ="POST">
                        <input type="hidden" value="<?php echo $_POST['idArmazem'] ?>" name="idArmazem">
                        <input type="submit" value="Voltar" class="btnUser">
                    </form>
				</div>
				</center>
			</div>
			
			
        </div>

	    <?php

        	include("includes/footer.php");
    
    	?>
	</div>
</body>

	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
