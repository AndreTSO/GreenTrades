

<!DOCTYPE html>
<html lang="pt">
    <head>
        <?php 
            require_once 'includes/config.php';   
            require_once 'classes/consumidor.php';
            require_once 'classes/encomenda.php';
            require_once 'classes/user.php';
            require_once("classes/produto.php");
            
            
            $ctrlConsumidor = new consumidor($db, $_SESSION['nif']); 
            $ctrlEncomenda=new encomenda($db);
            $ctrlUser = new user($db); 
            $ctrlProd = new produto($db);
            

        ?>
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
        <link rel="stylesheet" href="css/cuteAlertstyle.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="js/cute-alert.js"></script>
        <script src="js/extraFunctions.js"></script>


        <script>
            function wc(){ // Wipe Cesto
                eraseCookie("cesto");
                location.reload();
            }

            function eraseCookie(name) {   
                document.cookie = name+'=; Max-Age=-99999999;';  
            }


        </script>

            <?php 

if (isset($_POST['codigo']) && $_POST['codigo'] == 3) {
	
	$idEncomenda = "";
	$resposta =  $ctrlEncomenda->createEncomenda($_SESSION['nif'], $_POST['nome'], $_POST['sobreNome'], $_POST['email'],$_POST['contacto'], $_POST['nif'], $_POST['morada'], $_POST['codigoPostal'], $_POST['distrito'], $_POST['concelho'], date("d-m-Y"), 1, 0 , $_POST['aditional'],"", $_POST['trans'], $_POST['valorFinal']);

	if ($resposta != false){
        $idEncomenda = $resposta;
		//IR PRODUTO A PRODUTO VER O OWNER ... I WANNA CrY

		$resultadoBDGROSSO = $ctrlConsumidor->getArtigosCesto();// Saca todos os artigos

		if ($resultadoBDGROSSO && $resultadoBDGROSSO->RecordCount() > 0) {
			$cestoSplited = array();
			while ($linha = $resultadoBDGROSSO->FetchRow()) {
				array_push($cestoSplited,  $linha['idArtigo'] . ":" . $linha['quantidade']);
			}

			$fornecedores = array();

			foreach($cestoSplited as $artigo){
				
				$artigo2 = explode(":", $artigo);
				
				$forn = $ctrlProd->getTodosOsDados($artigo2[0])['idFornecedor'];
				if (empty($fornecedores)){
					array_push($fornecedores, $forn);
				}else{
					$flagExiste = false;
					foreach($fornecedores as $forni){
						if ($forni == $forn){
							$flagExiste = true;
						}
					}
					if (!$flagExiste){
						array_push($fornecedores, $forn);
					}
				}
			}

			foreach ($fornecedores as $forn){
				$subEncomenda = $ctrlEncomenda->createSubEncomenda($resposta ,1,0,$forn);

				foreach ($resultadoBDGROSSO as $produto) {
					$idArmazem = $ctrlProd->existeProdutoArmazem2($produto['idArtigo']);
					$dadosProduto = $ctrlProd->getTodosOsDados($produto['idArtigo']);
					
					if ($forn == $dadosProduto['idFornecedor']){
						$finalStep = $ctrlEncomenda->createArtigoSubEncomenda($subEncomenda, $idArmazem['idArmazemFornecedor'],$dadosProduto['nome'],$dadosProduto['descricao'],$produto['quantidade'], $dadosProduto['precoSemIva'] , 0, $dadosProduto['idProduto'], $dadosProduto['tipoIVA']);
					}
				}
				
				$ctrlUser->setNotify($forn, "Tem uma nova encomenda", "Tem uma nova encomenda");
                
			}

			

		}
	}else{
		//Nao foram encontrados artigos RISE ERROR
	}
	

    $ctrlConsumidor->wipeCesto();
		
}


            ?>


        </head>
    <body>
        <div class="body">            
            <?php
                include("topo.php") 
            ?>
            <div class="page">
                <div class="content">
                    <center>
                    <h2>Pagamento</h2>
                    
                    <hr>
                    <br>
                    <?php 
                    
                    
                        echo "<h6>Valor da Encomenda: ".$_POST['valorFinal']."€ </h6>"; 
                        echo "<br>";
                        echo "<br>";
                    
                    
                    
                    ?>
                     <!-- Replace "test" with your own sandbox Business account app client ID -->
                        <script src="https://www.paypal.com/sdk/js?client-id=AXeKrWhuFPxnXlW1Cu1GhUg8C2Q-VVNp09HFj26vOqRNGt71YVwvpqJ_cwb3Bef2hGFoDyrjLqVDwzQm&currency=EUR"></script>
                        <!-- Set up a container element for the button -->
                        <div id="paypal-button-container"></div>
                        <script>
                        paypal.Buttons({
                            // Sets up the transaction when a payment button is clicked
                            createOrder: (data, actions) => {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: <?php echo $_POST['valorFinal']; ?> // Can also reference a variable or function
                                    }
                                }]
                            });
                            },
                            // Finalize the transaction after payer approval
                            onApprove: (data, actions) => {
                            return actions.order.capture().then(function(orderData) {
                                // Successful capture! For dev/demo purposes:
                                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                const transaction = orderData.purchase_units[0].payments.captures[0];
                                //const idEncomenda = orderData.purchase_units[1].payments.captures[0];
                                //alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                //alert(`idEncomenda ${idEncomenda.status}: ${transaction.id}\n\nSee console for all available details`);
                                // When ready to go live, remove the alert and show a success message within this page. For example:
                                // const element = document.getElementById('paypal-button-container');
                                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                // Or go to another URL:  actions.redirect('thank_you.html');

                                $.ajax({
                                    type: "POST",
                                    url: 'ajax_encomenda.php',
                                    data: {codigo: 5745, idEncomenda: <?php echo $idEncomenda; ?>},
                                    dataType: "html",
                                    success: function (data){
                                        alert(data);
                                        if (data=="1") {
                                        

                                            $.ajax({
                                                type: "POST",
                                                url: 'GEN_PDF.php',
                                                data: {geraPDF: 5745, idEncomenda: <?php echo $idEncomenda; ?>},
                                                dataType: "html",
                                                success: function (data){
                                                    alert(data);
                                                    if (data=="1") {
                                                       
                                                    }
                                                }
                                            });

                                            window.location.href = "thank_you.php";

                                        }
                                    }
                                });

                                

                            });
                            }
                        }).render('#paypal-button-container');
                        </script>


                        <script>
                            function geraPDF(){
                                $.ajax({
                                        type: "POST",
                                        url: 'GEN_PDF.php',
                                        data: {geraPDF: 5745, idEncomenda: <?php echo $idEncomenda; ?>},
                                        dataType: "html",
                                        success: function (data){
                                            alert(data);
                                            if (data=="1") {
                                                
                                            }
                                        }
                                    });
                            }

                        </script>

                    </center>
                    

                </div>

            </div>

            <?php

                include("includes/footer.php")

            ?> 
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="js/navbar.js"></script>

	    <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.pkgd.js"></script>
        <script src="js/slides.js"></script>
    </body>
</html>