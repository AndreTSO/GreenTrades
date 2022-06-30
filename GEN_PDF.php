

<?php
require_once('classes/fpdf.php');


class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	// Logo
	$this->Image('images/logo1.png',25,20,33);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Movernos a la derecha
	$this->Cell(1);
	// Título
	$this->Cell(100,0,'Fatura - Greentrades',0,10,'L');
	$this->Ln(0);
	//$this->Line(0,10, 500,10);

	// Salto de línea
	
}

// Pie de página
function Footer()
{
	// Posición: a 1,5 cm del final
	$this->SetY(-20);
	// Arial italic 8
	$this->SetFont('Arial','I',5);
	// Número de página
	$this->Cell(0,10,'*Processado por programa certificado por Emanuel Nunes',0,1,'L');
	
	$this->SetFont('Arial','I',8);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}


}


if (isset($_POST['geraPDF']) or 1==1){


	include("includes/config.php");



	include 'classes/district.php';
	$ctrldistrict = new handlerDistrict();

	include 'classes/user.php';
	$ctrlUser = new user($db);

	require_once 'classes/encomenda.php';
	$ctrlEncomenda=new encomenda($db);

	require_once 'classes/transportador.php';
	$ctrlTransportador=new transportador($db);

	if (!$ctrlUser->islogged())
		header('Location: RAW_index.php');
	//EJECT




// Creación del objeto de la clase heredada

$dadosDoHome = $ctrlUser->getTodosOsDados($_SESSION['nif']);

$idFatura = 1;
$dia = date("d-m-Y");
$dataVenc =  date("d-m-Y", strtotime("+1 day"));
$nomeCliente = $dadosDoHome['nome'];
$moradaCliente =  $dadosDoHome['morada'];
$codigoPostal = $dadosDoHome['codigoPostal']." ".$ctrldistrict-> getConcelhoById($db,$dadosDoHome['concelho']);

$encomendaID  = $_POST['idEncomenda'];


$encomenda = $ctrlEncomenda->getTodosOsDadosEncomenda($encomendaID);

$original = "Original";
$referencia = $encomenda['refEncomenda'];
$contribuite = $encomenda['nif'];


$transportadora = $ctrlTransportador->getTodosOsDados($encomenda['transportadora'])['nomeEmpresa'];
$cliente = $encomenda['idCliente'];
$portes = "0";
$via = 1;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//$pdf->Line(0,40, 100,40);
$pdf->Ln(1);
$pdf->Cell(0,6,'                                                                                              Fatura Simplificada  FS/'.str_pad($idFatura, 6, '0', STR_PAD_LEFT).'                    '. $original,0,1, 'L');
$pdf->Cell(0,6,'                                                                                                                                                                          Via '.$via ,0,1, 'L');
$pdf->Ln(11);
$pdf->Cell(0,6,"                                                                                              Exmo..(s) Senhor(es)",0,1, 'L');
$pdf->Line(110,40, 200,40);
$pdf->Cell(0,6,"                                                                                              ".$nomeCliente,0,1, 'L');
$pdf->Cell(0,6,"                                                                                              ".$moradaCliente,0,1, 'L');
$pdf->Cell(0,6,"                                                                                              ".$codigoPostal,0,1, 'L');
//$pdf->Line(11,55, 100,55);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,23,'Encomenda '.$referencia,0,0);
$pdf->Ln();
$pdf->Line(10,72, 200,72);

$pdf->Cell(60,0,"Emitido em",0,0,'L');
$pdf->Cell(70,0,"Condições Pagamento",0,0,'C');
$pdf->Cell(60,0,"Vencimento em",0,0,'R');
$pdf->Ln();

$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,$dia,0,0,'L');
$pdf->Cell(70,8,"Multibanco",0,0,'C');
$pdf->Cell(60,8,$dataVenc,0,0,'R');
$pdf->Line(10,90, 200,90);

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times','B',12);
$pdf->Cell(50,0,"V/Documento",0,0,'C');
$pdf->Cell(50,0,"Cliente Nº",0,0,'C');
$pdf->Cell(50,0,"V/Contribuinte",0,0,'C');
$pdf->Cell(50,0,"Transporte",0,0,'C');
$pdf->Ln();


$pdf->SetFont('Times','',12);
$pdf->Cell(50,8,"",0,0,'C');
$pdf->Cell(50,8,$cliente,0,0,'C');
$pdf->Cell(50,8,$contribuite,0,0,'C');
$pdf->Cell(50,8,$transportadora,0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Line(10,108, 200,108);
$header = array(
	0 => "REFERENCIA",
	1 => "NOME",
	2 => "QUANT",
	3 => "UNI",
	4 => "P.VENDA S/IVA",
	5 => "DESC",
	6 => "VALOR LIQUIDO",
	7 => "IVA",
);

$artigos  = $ctrlEncomenda->getArtigosSubEncomenda($encomendaID);

$data = array();
foreach ($artigos as $artigo){
	$linha = array (0 => str_pad($artigo['idArtigo'], 8, '0', STR_PAD_LEFT) , 1 => $artigo['nome'],2 => $artigo['quantidade'], 3=> "UNI", 4=> round($artigo['valorArtigo'],2), 5=> "", 6=> $artigo['ivaArtigo']);
	array_push($data, $linha);
}

//$pdf->ImprovedTable($header,$data);




// Largura de las columnas
$pdf->SetFont('Times','B',8);
$w = array(20, 50, 30,20,20,20,15,20);
// Cabeceras

$pdf->Cell($w[0],7,$header[0],0,0,'L');
$pdf->Cell($w[1],7,$header[1],0,0,'L');
$pdf->Cell($w[2],7,$header[2],0,0,'R');
$pdf->Cell($w[3],7,$header[3],0,0,'L');
$pdf->Cell($w[4],7,$header[4],0,0,'C');
$pdf->Cell($w[5],7,$header[5],0,0,'C');
$pdf->Cell($w[6],7,$header[6],0,0,'C');
$pdf->Cell($w[7],7,$header[7],0,0,'C');
$pdf->Ln();
// Datos

$pdf->SetFont('Times','',8);
$valorTotal = 0;
$valorIva23 = 0;
$valorIva22 = 0;
$valorIva18 = 0;
$valorIva13 = 0;
$valorIva12 = 0;
$valorIva9 = 0;
$valorIva6 = 0;
$valorIva5 = 0;
$valorIva4 = 0;

foreach($data as $row)
{
	$pdf->Cell($w[0],6,$row[0],0,0,'L');
	$pdf->Cell($w[1],6,$row[1],0,0,'L');
	$pdf->Cell($w[2],6,$row[2],0,0,'R');
	$pdf->Cell($w[3],6,$row[3],0,0,'L');
	$pdf->Cell($w[4],6,$row[4],0,0,'C');
	$pdf->Cell($w[5],6,$row[5],0,0,'C');
	$pdf->Cell($w[6],6,$row[2]*$row[4],0,0,'C');
	$pdf->Cell($w[7],6,$row[6].'%',0,0,'C');
	
	$pdf->Ln();

	$valorTotal = ($row[2] * $row[4] ) + $valorTotal;

	if ($row[6] == "23"){
		$valorIva23 = $valorIva23+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "22"){
		$valorIva22 = $valorIva22+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "18"){
		$valorIva18 = $valorIva18+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "13"){
		$valorIva13 = $valorIva13+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "12"){
		$valorIva12 = $valorIva12+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "9"){
		$valorIva9 = $valorIva9+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "6"){
		$valorIva6 = $valorIva6+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "5"){
		$valorIva5 = $valorIva5+ ( $row[2] * $row[4] );
	}
	if ($row[6] == "4"){
		$valorIva4 = $valorIva4+ ( $row[2] * $row[4] );
	}


}

for ($i = count($data); $i<=10; $i++){
	$pdf->Ln();
}

$pdf->Ln();
$pdf->Cell(array_sum($w)-5,0,'','T');
$pdf->Ln();



$w = array(20, 20, 50,48,50);

$pdf->Cell($w[0],7,"Incidencias",0,0,'L');
$pdf->Cell($w[1],7,"Taxa",0,0,'L');
$pdf->Cell($w[2],7,"Valor IVA",0,0,'L');
$pdf->Cell($w[3],7,"TOTAL BRUTO",0,0,'L');
$pdf->Cell($w[4],7,$valorTotal." EUR",0,0,'R');

$pdf->Ln();


$linha1 = "DESCONTO LINHA";
$linha1End = "0 EUR";

$linha2 = "DESCONTO GLOBAL";
$linha2End = "0 EUR";

$linha3 = "TOTAL LIQUIDO";
$linha3End = $valorTotal." EUR";

$linha4 = "TOTAL IVA";
$iba = round($valorIva23*0.23+$valorIva22*0.22+$valorIva18*0.18+$valorIva13*0.13+$valorIva12*0.12+$valorIva9*0.09+$valorIva6*0.06+$valorIva5*0.05+$valorIva4*0.04, 2);
$linha4End = $iba." EUR";



$linha5 = "TOTAL PORTES";
$linha5End = $portes." EUR";

$where = 0;
if ($valorIva23 !=0){

	$pdf->Cell($w[0],7,$valorIva23,0,0,'C');
	$pdf->Cell($w[1],7,"23%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva23*0.23, 2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}


if ($valorIva22 !=0){

	$pdf->Cell($w[0],7,$valorIva22,0,0,'C');
	$pdf->Cell($w[1],7,"22%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva22*0.22,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}


if ($valorIva18 !=0){

	$pdf->Cell($w[0],7,$valorIva18,0,0,'C');
	$pdf->Cell($w[1],7,"18%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva18*0.18,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

if ($valorIva13 !=0){

	$pdf->Cell($w[0],7,$valorIva13,0,0,'C');
	$pdf->Cell($w[1],7,"13%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva13*0.13,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

if ($valorIva12 !=0){

	$pdf->Cell($w[0],7,$valorIva12,0,0,'C');
	$pdf->Cell($w[1],7,"12%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva12*0.12,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

if ($valorIva9 !=0){

	$pdf->Cell($w[0],7,$valorIva9,0,0,'C');
	$pdf->Cell($w[1],7,"9%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva9*0.09,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}



if ($valorIva6 !=0){

	$pdf->Cell($w[0],7,$valorIva6,0,0,'C');
	$pdf->Cell($w[1],7,"6%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva6*0.06,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

if ($valorIva5 !=0){

	$pdf->Cell($w[0],7,$valorIva5,0,0,'C');
	$pdf->Cell($w[1],7,"5%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva5*0.05, 2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

if ($valorIva4 !=0){

	$pdf->Cell($w[0],7,$valorIva4,0,0,'C');
	$pdf->Cell($w[1],7,"4%",0,0,'L');
	$pdf->Cell($w[2],7,round($valorIva4*0.04,2),0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}

for ($i = $where; $i <=4 ; $i++){

	$pdf->Cell($w[0],7,"0",0,0,'C');
	$pdf->Cell($w[1],7,"0%",0,0,'L');
	$pdf->Cell($w[2],7,"0",0,0,'L');

	if ($where == 0){
		$pdf->Cell($w[3],7,$linha1,0,0,'L');
		$pdf->Cell($w[4],7,$linha1End,0,0,'R');
		
	}
	if ($where == 1){
		$pdf->Cell($w[3],7,$linha2,0,0,'L');
		$pdf->Cell($w[4],7,$linha2End,0,0,'R');
		
	}
	if ($where == 2){
		$pdf->Cell($w[3],7,$linha3,0,0,'L');
		$pdf->Cell($w[4],7,$linha3End,0,0,'R');
		
	}
	if ($where == 3){
		$pdf->Cell($w[3],7,$linha4,0,0,'L');
		$pdf->Cell($w[4],7,$linha4End,0,0,'R');
		
	}
	if ($where == 4){
		$pdf->Cell($w[3],7,$linha5,0,0,'L');
		$pdf->Cell($w[4],7,$linha5End,0,0,'R');
		
	}
	$where +=1;
	$pdf->Ln();
}
$pdf->Cell(array_sum($w),0,'','T');
//$pdf->Line(0,90, 500,90);
$pdf->Ln();
$pdf->SetFont('Times','B',12);
$w = array(90, 40, 60);

$pdf->Cell($w[0],7,"",0,0,'L');
$pdf->Cell($w[1],7,"TOTAL",0,0,'L');
$pdf->Cell($w[2],7,round ($iba + $valorTotal + $portes , 2)." EUR ",0,0,'R');
$pdf->Output("F", "pdf/nome.pdf", TRUE);

	echo "1";
}else{
	echo "0";
}
?>


