<?php        
class comentarios{
	
	var $db;
	var $prefixo;
		
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
		
	}
	/**
	 * Regista 
	 */
	function criaComentario($nif ,$idProduto, $estrelas,  $comentario){
        $dados = array();
		$dados[0]= $nif;
		$dados[1]= $idProduto;
		$dados[2]= $comentario;
		$dados[3]= $estrelas;
		$dados[4]= 18;
		$dados[5]= date("d/m/Y");

        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."comentariosreview (idUser, idProduto, comentario, estrelas, estado, data) 
        VALUES (?, ?, ?, ?, ?, ?)");


		$algo = $this->db->execute($registar, $dados);
		if ($algo){
			return true;
		}
		return false;

		//INSERT INTO ptr_userreistado (nif, nome, sobreNome, genero, email, senha, morada, codigoPostal, distrito, concelho, dataNascimento, tipoDeConta, contacto, anuncios, apiKey)  VALUES (596, "ema", "nunes", "M", "emanuel@gmail.com", "$$2y$10$SMM5OxvWQbUpcsR4RbhhmuYiNT1G2EtuwDew6tLTMshJElCBOvvNy", "123123", "2660-368", 1, 1, "2022-04-20", 1, 965, 1, "2MB9IMMY0Q7I0C80G5D7E9RK1IJQOWB0OG1BFPX5WU25G");

    }

	function getStarsValue($idProduto){
		
		$query = $this->db-> prepare("SELECT AVG(estrelas), count(estrelas) FROM ".$this->prefixo."comentariosreview WHERE idProduto = ".$idProduto);
		$resultado = $this->db->execute($query);
		if ($resultado && $resultado -> RecordCount()>0){
			$linha = $resultado->FetchRow();
			$str = $linha[0].":".$linha[1];
			return $str;
		}
		return 0;
	}

	function getComentarios($idProduto){

		$query = $this->db-> prepare("SELECT * FROM ".$this->prefixo."comentariosreview WHERE idProduto = ".$idProduto);
		$resultado = $this->db->execute($query);
		$r = null;
		$retorno = array();
		if ($resultado && $resultado -> RecordCount()>0){
			while ($linha = $resultado->FetchRow()){
				$r = array(
					"idUser"  => $linha['idUser'],
					"comentario" => $linha['comentario'],
					"estrelas" => $linha['estrelas'],
					"data" => $linha['data']
					);

				array_push($retorno, $r);
			}
		}
		return $retorno;


	}


}


/**
 * 
 * if ($resultado && $resultado->RecordCount()>0){
 *					
 *	while ($linha=$resultado->FetchRow()){
 *		echo "<option value='".$linha['id']."'  >".$linha['name']."</option>";
 *	}
 * 
 * 
 * 
 */

?>