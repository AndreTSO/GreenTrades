<?php        
class enviadorDeEmail{
	
	
	function __construct(){}
	
	
	function recuperarSenha($zmail, $dominio, $idUser, $nome){
		
		//$q=(string)('Select * from pessoa where email = \'$zmail\' ');
	
		

			$code= md5(md5($idUser.$zmail).SENHA);
			
			$subject = "GreenTrades - Recuperação da senha parte 1/2";
			
			$message ='<html><body style="background-color:white; color:black !important; border-radius:10px; padding:20px;">';		
			//$message .='<img src=\"'.$dominio.'/images/logo.png\">';
			$message .='<h1>Recuperação da Senha</h1>';
			$message .='<p>Olá '.$nome.'<br>';
			$message .='Enviamos-lhe um link para poder repor a sua senha</p><br>';
			$message .='<p style="text-decoration:none;">'.$dominio.'/ajax_user.php?codigo=9&id='.$code.'&email='.$zmail.'&value='.$idUser.'</p><br>';
			$message .='<a href="'.$dominio.'/ajax_user.php?codigo=9&id='.$code.'&email='.$zmail.'&value='.$idUser.'" style="text-decoration:none;"><button style="border-radius:10px; background-color:#ff9000; padding:15px; border:none; color:white;">Repor Senha</button></a><br><br>';
			$message .='<p style="text-decoration:none;">Voce recebeu este email porque solicitou a recuperação da senha de acesso ao '.$dominio.' no dia '.date("d/m/Y").' às '. date("G:i:s").'</p>';
			$message .='<p>Se não solicitou este email, por favor ignore</p>';
			$message .='</body></html>';

			//Headers
			$headers = "From: GreenTrades \r\n";
			$headers .= "Reply-To: no-reply@greentrades.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
			return mail($zmail, $subject, $message, $headers);
		

	}
	
	function enviarSenha($dominio, $senhaNova, $zmail, $nome){
		


		$subject = "GreenTrades - Recuperação da senha Parte 2/2";
		
		$message ='<html><body style="background-color:white; color:black !important; border-radius:10px; padding:20px;">';
		//$message .='<img src=\"'.$dominio.'/images/logo.png\">';
		$message .='<h1>Recuperação da Senha</h1>';
		$message .='<p>Olá '.$nome.'<br>';
		$message .='Concluindo a recuperação da sua senha, esta é a nova senha.</p><br>';
		$message .='<h1>'.$senhaNova.'</h1>';
		$message .='<p style="text-decoration:none;">Voce recebeu este email porque solicitou a recuperação da senha de acesso ao '.$dominio.' no dia '.date("d/m/Y").' às '. date("G:i:s").'</p>';
		$message .='<p>Se não solicitou este email, por favor ignore</p>';
		$message .='</body></html>';

		// Headers
		$headers = "From: GreenTrades \r\n";
		$headers .= "Reply-To: no-reply@greentrades.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
		return mail($zmail, $subject, $message, $headers);
	
		
		
		
	}
	
	function activarConta($zmail, $dominio, $nome, $id ){
		
			$code= md5(md5($id.$zmail).SENHA);
			
			$subject = "GreenTrades - Ativação de conta";
			
			
			//$message = 'Enviamos-lhe um link para poder repor a sua senha'.$dominio.'//repor.php?id='.$code.'Se não solicitou este email, por favor ignore';
			$message ='<html><body style="background-color:white; color:black !important; border-radius:10px; padding:20px;">';
			
			//$message .='<img src=\"'.$dominio.'/images/logo.png\">';
			$message .='<h1>Ativaçao de conta</h1>';

			$message .='<p>Olá '.$nome.'<br>';
			$message .='Enviamos-lhe um link para poder ativar a sua senha</p><br>';
			$message .='<p style="text-decoration:none;">'.$dominio.'/ajax_user.php?id='.$code.'&email='.$zmail.'&value='.$id.'&codigo=7</p><br>';
			/*$message .='<a href=\"'.$dominio.'/repor.php?id='.$code.'\">'.$dominio.'/repor.php?id='.$code.'</a><br><br>';*/
			$message .='<a href="'.$dominio.'/ajax_user.php?id='.$code.'&email='.$zmail.'&value='.$id.'&codigo=7" style="text-decoration:none;"><button style="border-radius:10px; background-color:#ff9000; padding:15px; border:none; color:white;">Ativar Conta</button></a><br><br>';
			$message .='<p style="text-decoration:none;">Voce recebeu este email porque se registou no website '.$dominio.' no dia '.date("d/m/Y").' às '. date("G:i:s").'</p>';
			$message .='<p>Se não solicitou este email, por favor ignore</p>';
			$message .='</body></html>';
			$headers = "From: GreenTrades \r\n";
			$headers .= "Reply-To: no-reply@greentrades.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
							
			return mail($zmail, $subject, $message, $headers);	
		return false;
	}
	
	function contactarEmpresa($emailEmpresa, $servico, $assunto, $mensagem, $nomePessoa,$emailPessoa){
		
		$subject = $servico." - ".$assunto;
			
		$message ='<html><body style="background-color:black; color:#ff9000 !important; border-radius:10px; padding:20px;">';		
		$message .='<h1>'.$servico." - ".$assunto.'</h1>';
		$message .='<h3>Email para poder responder: '.$emailPessoa.'</h3>';
		$message .='<p>Nome da Pessoa: '.$nomePessoa.'<br>';
		$message .='<h3>Corpo da Mensagem:</h3><br>';
		$message .='<p>'.$mensagem.'</p>';
		$message .='</body></html>';

		//Headers
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
		return mail($emailEmpresa, $subject, $message, $headers);
	
		
	}
	
	function alertValidades($nome, $email, $listaPRodutos){

		$subject = "Greentrades - Alerta de validades";
			
		$message ='<html><body style="color:black !important; border-radius:10px; padding:20px;">';		
		$message .='<h1>Greentrades - Alerta de validades</h1>';
		$message .='<h3>Carissimo representante '.$nome.'</h3>';
		$message .='<p>Vimos por este meio notificar para o facto de alguns produtos da sua empresa estarem a passar de validade.<p><br>';
		$message .='<table>
						<tr>
							<th>Imagem</th>
							<th>Nome Artigo</th>
							<th>Estado</th>
							<th>Notificação</th>
						</tr>';
							foreach($listaPRodutos as $linhaProduto){
		$message .='			<tr>
									<td><img src="ptr.emanuelnunes.pt/images/IMG_PRODUTOS/'.$linhaProduto['imgProduto'].'" width="50px" height="50px;"></td>';				
		$message .='				<td>'.$linhaProduto['nome'].'</td>';				
		$message .='				<td><img src="ptr.emanuelnunes.pt/images/'.$linhaProduto['sinal'].'" width="15px" height="15px;"></td>';				
		$message .='				<td>'.$linhaProduto['texto'].'</td>
								</tr>';					
							}
		$message .='	
		
					</table><br>';

		$message .='</body></html>';

		//Headers
		
		$headers = "From: GreenTrades \r\n";
		$headers .= "Reply-To: no-reply@greentrades.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
		return mail($email, $subject, $message, $headers);
	
		


	}

	
	
}	
?>