<?php 

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Gestione Mail
 * Version:           1.1
 * Requireds PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

global $wpdb;
global $HR_MODULE;
global $HR_CANDIDATE;


/**
 * Ordina i Dati prelevati dal Form
 * per la creazione di un oggetto
 * 'Dati Candidato'
 */
if(!isset($_POST['id'])){

  $string = $HR_MODULE->ObjectMOD(intval($_POST['id'])); // Restituisce il contenuto del Modulo
  $_mail_ = "";
  $_file_ = "";

  $arrayString = explode('&', $string); // Divide i vari campi
  $arrayObj = [];

    foreach ($arrayString as $key => $value) {
      $arrayObj[$key] = json_decode($value); // Decodifica in array di oggetti il singolo JSON
    }

  // Array Associativo Singolo Dato
  $dato = [
    'title' => '',
    'valore' => ''
  ];

  // Array contenente i dati del candidato
  $candidato = [];

  for ($i = 1; $i < count($arrayObj)-1; $i++) {

    $val = true;

    foreach ($_POST as $key => $value) {

      if(strval($arrayObj[$i]->name) == strval($key)){

        if(strval($arrayObj[$i]->type) == strval('email')){
          $_mail_ = $value;
        }

        //Inserimento per comparazione
        $dato['title'] = $arrayObj[$i]->title;
        $dato['valore'] = $value;
        $candidato[$i] = $dato;

        $val = false;

      }
      
    }

    foreach ($_FILES as $key => $value) {
      if(strval($arrayObj[$i]->name) == strval($key)){
        $val = false;
      }
    }

    if($val){
      //Inserimento dato non compilato
      $dato['title'] = $arrayObj[$i]->title;
      $dato['valore'] = '****';
      $candidato[$i] = $dato;
    }

  }

  // Creo il Codice identificativo dell'utente
  $id_code = $HR_CANDIDATE->setCode(intval($_POST['id']));

  date_default_timezone_set('Europe/Rome');    
  $newCandidate = array(
    "id_code" => $id_code,
    "mail" => $_mail_,
    "registered" => date("Y/m/d H:i:sa", time()),
    "url_directory" => "candidate/" . $_POST['dir'] . "/" . strtolower($id_code),
    "id_module" => intval($_POST['id'])
  );

  if($HR_CANDIDATE->sendMail($_mail_, $id_code, intval($_POST['id']))){

    /**
     * Aggiunge il candidato al DB
     */
    $HR_CANDIDATE->add($newCandidate);


    /**
     * Crea il percorso e cartella del candidato
     */
    $HR_CANDIDATE->DIR_Generator($id_code, $candidato, $_FILES, $_POST['dir']);

  }

}
