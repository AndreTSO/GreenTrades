<?php        
class veiculo{
	
	var $db;
	var $prefixo;
	
	function __construct($db){
		$this->db = $db;
		$this->prefixo = "ptr_";
	}

	function createVeiculo($idBaseTransportador, $matricula, $anoDoVeiculo, $tipoVeiculo, $marca, $consumoPorCemKm, $tipoDeCombustivel, $cargaMaxima,$estado, $frigorifico){
		$dados = array();
		$dados[0]= $idBaseTransportador;
		$dados[1]= $matricula;
		$dados[2]= $anoDoVeiculo;
		$dados[3]= $tipoVeiculo;
		$dados[4]= $marca;
		$dados[5]= $consumoPorCemKm;
		$dados[7]= $tipoDeCombustivel;
		$dados[8]= $cargaMaxima;
		$dados[9]= $estado;
		$dados[10]= $frigorifico;
        $registar = $this->db-> prepare("INSERT INTO ".$this->prefixo."veiculostransportador (idBaseTransportador, matricula, anoDoVeiculo, tipoVeiculo, marca, consumoPorCemKm, tipoDeCombustivel, cargaMaxima, estado, frigorifico) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  

		$algo = $this->db->execute($registar, $dados);
		if ($algo)
			return true;
		return false;
	}

	function existVeiculo($idTransportador){
		$veiculos = array();
		$query = $this->db-> prepare("SELECT idBase FROM ".$this->prefixo."basestransportador WHERE idTransportador =".$idTransportador);
		$resultado = $this->db->execute($query);
		if($resultado->RecordCount()>0){
			while($linha=$resultado->FetchRow()){
				$q = "SELECT * FROM ".$this->prefixo."veiculostransportador WHERE idBaseTransportador= ".$linha[0];
				$resultado2 = $this->db->execute($q);
				if($resultado2->RecordCount()>0){
					while($linha2=$resultado2->FetchRow())
					array_push($veiculos, $linha2);
				}
			}
		}
		return $veiculos;	
	}

	function getTodosOsDados($idVeiculo){
		$veiculo = $this->db-> prepare("SELECT * FROM ".$this->prefixo."veiculostransportador WHERE idVeiculo= ".$idVeiculo); 
		$resultado = $this->db->Execute($veiculo);
		
		if ($resultado && $resultado->RecordCount()>0) { 
			$linha=$resultado->FetchRow();
			$resultado2 = array(
				"idVeiculo" => $linha['idVeiculo'],
				"idBaseTransportador" => $linha['idBaseTransportador'],
                "matricula" => $linha['matricula'],
                "anoDoVeiculo" => $linha['anoDoVeiculo'],
                "tipoVeiculo" => $linha["tipoVeiculo"],
                "marca" => $linha["marca"],
                "consumoPorCemKm" => $linha["consumoPorCemKm"],
                "tipoDeCombustivel" => $linha["tipoDeCombustivel"],
                "cargaMaxima" => $linha["cargaMaxima"],
                "estado" => $linha["estado"],
                "frigorifico" => $linha["frigorifico"]
			);
			return $resultado2;
		}
		return null;
	}

	function deleteVeiculo($idVeiculo){
		$produto = $this->db-> prepare("UPDATE ".$this->prefixo."veiculostransportador SET estado = 0 WHERE idVeiculo=".$idVeiculo." AND estado !=20");
		$algo = $this->db->execute($produto);
		if($algo){
			$bosta= $this->db-> execute("SELECT estado FROM ".$this->prefixo."veiculostransportador WHERE estado = 0 AND idVeiculo=".$idVeiculo);
			
			if($bosta && $bosta->RecordCount()>0)		
				return true;
			return false;
		}	
		return false;
	}

	function setTodosOsDados($idVeiculo,$idBaseTransportador, $matricula, $anoDoVeiculo, $tipoVeiculo, $marca, $consumoPorCemKm, $tipoDeCombustivel, $cargaMaxima,$estado, $frigorifico){
		$dados = array();
        $dados[0]= $idBaseTransportador;
		$dados[1]= $matricula;
		$dados[2]= $anoDoVeiculo;
		$dados[3]= $tipoVeiculo;
		$dados[4]= $marca;
		$dados[5]= $consumoPorCemKm;
		$dados[6]= $tipoDeCombustivel;
		$dados[7]= $cargaMaxima;
		$dados[8]= $estado;
		$dados[9]= $frigorifico;
		$dados[10]= $idVeiculo;

		$queryUpdate = $this->db-> prepare("UPDATE ".$this->prefixo."veiculostransportador SET			
            idBaseTransportador = ?,
            matricula = ?,
            anoDoVeiculo = ?,
            tipoVeiculo = ?,
            marca = ?,
            consumoPorCemKm = ?,
            tipoDeCombustivel = ?,
            cargaMaxima = ?,
            estado = ?,
            frigorifico = ?
			WHERE idVeiculo = ?");

		$algo = $this->db->execute($queryUpdate, $dados);


		if ($algo)
			return true;
		return false;
    }
}
?>