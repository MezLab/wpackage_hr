<?php

require_once '../class/Classes/PHPExcel.php';

// Dati Database
$servername = 'localhost';
$username = 'infomobilityWP';
$password = 'Mob1l1t@';
$dbname = 'infomobility';

// Crea collegamento
$conn = new mysqli($servername, $username, $password, $dbname);
// Prova connessione
if($conn->connect_error) die( "Connessione fallita:" . $conn->connect_error);

$name_ = $_GET["name"];
$nameFile;

// Query selezione dati richiedenti
$ExcelID = $conn->query("SELECT ID, name FROM wpackage_hr_module WHERE code='" . $name_ . "'");

$arrayTemp = array();
$arrayTitolazioni = array();
$arrayDatiCandidati = array();
$size_2 = 0;

if ($ExcelID->num_rows > 0) {
  // Loop ID Code
  while($row = $ExcelID->fetch_assoc()) {
    $ExcelCandidate = $conn->query("SELECT id_code FROM wpackage_hr_candidate WHERE id_module =". intval($row["ID"]));
    $nameFile = $row["name"];
    // Loop Candidate where id_code ....
    while($row = $ExcelCandidate->fetch_assoc()) {
      $testo = file_get_contents(realpath(__DIR__) . "/../candidate/" . $name_ . "/" . strtolower($row["id_code"]) . "/" . $row["id_code"] . "_data.txt");
      $c = "";
      $size = 0;

      // Inserimento dati Candidato nell'array
      for ($b=0; $b < strlen($testo); $b++) { 
        if($testo[$b] == "\n"){
          $arrayTemp[$size] = $c;
          $c = "";
          $size++;
        }else{
          $c .= $testo[$b];
        }
      }
        
      for ($a=0; $a < count($arrayTemp); $a++) {
        $d = explode(" = ", $arrayTemp[$a]);
        $arrayTitolazioni[$a] = $d[0];
        $arrayDatiCandidati[$size_2] = str_replace(['{', '}'], '', $d[1]);
        $size_2++;
      }
    }
  }
}else {
  echo "0 results";
}

$stringTitle = implode(',', $arrayTitolazioni);
$stringCandidati = implode(',', $arrayDatiCandidati);

// Array Campi Titolazione
$intestazione = explode(',', $stringTitle);

// Array Dati dei Candidati
$dati = explode(',', $stringCandidati);

$letter = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

$newLetterColumn = array();

$n;

/** */
$a = sizeof($intestazione); // Numero di campi del Modulo
$b = sizeof($letter); //26

$c = floor($a / $b);
$e = $a % $b;
/** */

function repeatColumn(int &$q, array &$t, array &$p, int $size){
  for ($i = 0; $i < $q; $i++) { 
      array_push($t, $t[$size] . $p[$i]);
  }
}

for ($l = -1; $l < $c-1; $l++) { 
  repeatColumn($b, $newLetterColumn, $letter, $l);
  $n = $l;
  $n++;
}

if($e <= 0){
  
}else{
  for ($j=0; $j < $e; $j++) {
    array_push($newLetterColumn, $newLetterColumn[$n] . $letter[$j]);
  }
}


// Create new PHPExcel object

$_PHPExcel = new PHPExcel();

// Set document properties
$_PHPExcel->getProperties()->setCreator("MEZ")
							 ->setTitle( str_replace("_", " ", $_GET['nameFile']) . " - Infomobility")
							 ->setSubject("Office 2007 XLSX")
							 ->setDescription("Documento Generato per Infomobility");


// Add some data
$_PHPExcel->setActiveSheetIndex(0);

foreach ($newLetterColumn as $key => $value) {
  $_PHPExcel->getActiveSheet()
      ->setCellValue($value . '1', $intestazione[$key])
      ->getColumnDimension($value)->setWidth(20);
}

foreach ($newLetterColumn as $key => $value) {
  $_PHPExcel->getActiveSheet()
      ->getStyle($value . '1')->applyFromArray(
        array(
          'font' => array(
            'bold' => true
          )
        )
      );
}


$aa = 2;
$bb = 0;
for ($lol = 0; $lol < sizeof($dati)/sizeof($intestazione); $lol++) { 
  foreach ($newLetterColumn as $key => $value) {
    $_PHPExcel->getActiveSheet()
        ->setCellValue($value . strval($aa), $dati[$bb]);
        $bb++;
  }
$aa++;
}

// Rename worksheet
$_PHPExcel->getActiveSheet()->setTitle('Infomobility');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$_PHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $nameFile . ".xls");
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($_PHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;