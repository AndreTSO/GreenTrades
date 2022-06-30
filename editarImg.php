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

	<?php 
		include("includes/config.php");
		require_once("classes/lib.php");
		require_once('classes/produto.php');
        require_once 'classes/user.php';
        require_once 'classes/armazem.php';
   
	
		$ctrllib=new lib($db);	
        $ctrlUser=new user($db);
        $ctrlArmazens= new armazem($db);
        $ctrlProduto = new produto($db);


        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        if (isset($_SESSION['nif']) ){
            if (!$ctrlUser->isAuthorized(2,$_SESSION['nif'])){
                header('Location: RAW_index.php');
            }
        }

        if (!(isset($_POST['idProduto']))){
            header('Location: verProduto.php');
            
        }



        if (isset($_POST['idImgElim'])){
            if ($ctrlProduto->getImgByID($_POST['idProduto'], $_POST['idImgElim'])) { //SE existir a foto .. elimina a
				$ctrlProduto->remImg($_POST['idProduto'],$_POST['idImgElim']);
                $nomeFinal = $_POST['idImgElim'];
                $target_dir = "images/IMG_PRODUTOS/";
				unlink($target_dir.$nomeFinal);
                $_GET['status'] = 26;
			}
        }

        
        if (isset($_POST['idImgEdit'])){
            
            $nomeFinal = $_POST['idImgEdit'];
            $nome_ = str_replace(".", "_",$nomeFinal);
            adicionaImagem($_FILES[ $nome_ ],$nomeFinal,$_POST['idProduto'], $ctrlProduto);
            $_GET['status'] = 25;
        }

        if (isset($_POST['idImgAdd'])){
            
            $nomeFinal = $_POST['idImgAdd'];
            $nome_ = str_replace(".", "_",$nomeFinal);
            adicionaImagem($_FILES[ $nome_ ],$nomeFinal,$_POST['idProduto'], $ctrlProduto);
            $_GET['status'] = 25;
        }
        




		function adicionaImagem($_FILE, $nomeFinal, $idProduto, $ctrlProduto){
			$target_dir = "images/IMG_PRODUTOS/";
			

			if ($ctrlProduto->getImgByID($idProduto, $nomeFinal)) { //SE existir a foto .. elimina a
				$ctrlProduto->remImg($idProduto, $nomeFinal);
				unlink($target_dir.$nomeFinal);
			}
			$ctrlProduto->addImg($idProduto, $nomeFinal);

			

			$target_file = $target_dir . basename($_FILE["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			
			$check = getimagesize($_FILE["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$_GET['status'] = 28;
				$uploadOk = 0;
			}
			
			// Check if file already exists
			if (file_exists($target_file)) {
				$_GET['status'] = 29;
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILE["size"] > 1000000) {
                $_GET['status'] = 30;
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $_GET['status'] = 31;
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
                $_GET['status'] = 32;
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				$_FILE["name"] = $nomeFinal;
				$target_file = $target_dir . basename($_FILE["name"]);
				if (move_uploaded_file($_FILE["tmp_name"], $target_file)) {
					$_GET['status'] = 25;
				} else {
					$_GET['status'] = 27;
				}
			}
		}




	?>




</head>


<body>
    <div class="body">
        <?php 
            include 'topo.php';
        ?>
        <div class="page">
            <div class="content">
                <?php
                    include 'showMsg.php';
                ?>
                <h1>Imagens</h1>
                <br>
                
                <br>
            
            <?php
           

            $resultado = $ctrlProduto ->getImg($_POST['idProduto']);
            $contador = 0;
            $vetorImagensColocadasNomes = array();
            
            if(!empty($resultado)){
                
                foreach ($resultado as $img){
                    $contador+=1;

                    
                    echo (substr($img, -5) == '0.png'? "<h3>Capa do produto</h3>":'');



                    echo "<a href='images/IMG_PRODUTOS/".$img."' target='_blank'><img src='images/IMG_PRODUTOS/".$img."' width=100px; height:100px;/></a>
                    <span id='sub".$img."'>
                    <form method='POST' action='editarImg.php' enctype='multipart/form-data'>
                       ";
                        array_push($vetorImagensColocadasNomes, $img);

                       echo "
                        <input type='hidden' value='".$img."' name='idImgEdit'>
                        <input type='hidden' value='".$_POST['idProduto']."' name='idProduto'>
                        <input type='file' name='".$img."' required>
                        <input type='submit' value='Alterar'>
                   </form>
                    </span>
                    <span id='elm".$img."'>
                       <form method='POST' action='editarImg.php'>
                        <input type='hidden' value='".$img."' name='idImgElim'>
                        <input type='hidden' value='".$_POST['idProduto']."' name='idProduto'>
                        <input type='submit' value='Eliminar'>
                       </form>
                    </span>
                    
                    
                    
                    
                    <br>";

                }

                
            }else{

                ?>  
                    <br>
                    <br>
                    <br>
                    <br>
                    <h3>Este produto não tem imagens ainda</h3>
                <?php




            }

            if ($contador<11){
                echo "Pode inserir mais <span id='fotosExtra'>".(11-$contador)."</span> Imagens";
               
                $proximoArtigo ="";
                
                for ($i = 0; $i<=11; $i++){
                    
                    if (!(in_array("Art".$_POST['idProduto']."ID".($i).".png", $vetorImagensColocadasNomes))) {
                      
                        $proximoArtigo = "Art".$_POST['idProduto']."ID".($i).".png";
                        break;
                    }
                }

            

                ?>
                <h3>Inserir mais imagens</h3> 
                <form ACTION = "editarImg.php" METHOD = "POST" enctype="multipart/form-data">
                    <input type='hidden' name="idProduto" value='<?php echo $_POST['idProduto'];?>'></input>
                    <input type='hidden' name="idImgAdd" value='<?php echo $proximoArtigo;?>'></input>
                    <input type='file' name='<?php echo $proximoArtigo; ?>' ></input>
                    <input type="submit" value="adicionar">
                </form>

                <?php 
                
                }
            ?>

            <br>
            <br><a href="verProduto.php"><button>Voltar</button></a>
            </div>
           
        </div>
        <?php 
           // include 'includes/footer.php';
        ?> 
    </div>
    
</body>


	<!-- Jquery -->
	<script src="js/jquery-3.6.0.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
	<script src="js/jquery-ui.min.js"></script>
