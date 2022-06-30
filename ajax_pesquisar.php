<?php
include 'includes/config.php'; 
include 'classes/produto.php';
include 'classes/lib.php';
$ctrlProduto=new produto($db);
$ctrllib=new lib($db);


if (isset($_POST['codigo']) && $_POST['codigo'] == 1) {
	$produto =   $ctrlProduto->getProductsSite((isset($_POST['categoria'])?$_POST['categoria']:""), (isset($_POST['pesquisa'])?$_POST['pesquisa']:""), (isset($_POST['categoria2'])?$_POST['categoria2']:""));
	if (!empty($produto)) {
		$encontrei1 = false;
		foreach ($produto as $produtos){
			$preco = $ctrlProduto-> getRealPrice($produtos['idProduto']);
			if ($preco <= (isset($_POST['valor']) && ((trim($_POST['valor']) != "") && ($_POST['valor'] != 0))?$_POST['valor']:999999999)){
				$imagem = $ctrlProduto->getImg($produtos['idProduto']);
				$subCat = $ctrllib->getSubCategoriaNome($produtos['tags']);
				$imagemDIV = "";
				if(empty($imagem)){
					$imagemDIV = "<img src='images/IMG_PRODUTOS/noIMG.png'>";
				}else{
					$imagemDIV = "<img src='images/IMG_PRODUTOS/".$imagem[0]."'>";
				}
				echo "
					
						<a style='color:black;' href='prodShow?q=".$produtos['idProduto']."'>
							<div class='product'>
								<div class='product-img'>".
									$imagemDIV."
								</div>
								<div class='product-content'>
									<h3>".$produtos['nome']."
										
										<small>".$produtos['descricao']."</small>
									</h3>
									<p class='product-text price'>".$preco." €</p>
									<p class='product-text genre'>".$subCat."</p>
								</div>
							</div>
						</a>
					";
				$encontrei1 = true;
			}
		}
		if (!$encontrei1){
			echo "<center><img src='images/clippy.gif' width='130px' height='130px' style='border-radius:30px;' /><br>
		Não encontramos nenhum resultado, <br> Experimente mudar algo na sua pesquisa!</center>
			
		
		";
		}
	}else{
		echo "<center><img src='images/clippy.gif' width='130px' height='130px' style='border-radius:30px;' /><br>
		Não encontramos nenhum resultado, <br> Experimente mudar algo na sua pesquisa!</center>
			
		
		";
	}
}



?>