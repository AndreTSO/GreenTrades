
  
  
  <!DOCTYPE html>
<html lang="pt">
<head>

	<?php 
		include("includes/config.php");

        include 'classes/user.php';
        $ctrlUser=new user($db);

        if (!$ctrlUser->islogged())
	        header('Location: RAW_index.php');
            //EJECT
        
	?>


</head>
  
  <form  METHOD="POST" ACTION="ajax_user.php" name="registar">
            <input type="hidden" name="codigo" value=6>

            <input  name="nif" type="hidden"  value="<?php echo $_SESSION['nif']; ?>" >

            <input  name="password" type="password"  required placeholder="Insira a sua password para Validar">

            <input type="submit" value="Eliminar Definitivamente">

        </form>
